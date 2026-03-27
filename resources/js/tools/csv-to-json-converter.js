import Papa from 'papaparse';

const root = document.getElementById('csv-to-json-tool');

if (root) {
    const refs = {
        fileInput: document.getElementById('csv-file-input'),
        dropzone: document.getElementById('csv-dropzone'),
        fileBadge: document.getElementById('csv-file-badge'),
        fileState: document.getElementById('csv-file-state'),
        fileStateName: document.getElementById('csv-file-state-name'),
        replaceFileButton: document.getElementById('replace-csv-file'),
        removeFileButton: document.getElementById('remove-csv-file'),
        openPreviewButton: document.getElementById('open-csv-preview'),
        inputTabs: Array.from(document.querySelectorAll('[data-csv-input-tab]')),
        inputPanels: Array.from(document.querySelectorAll('[data-csv-input-panel]')),
        inputCard: document.getElementById('csv-input-card'),
        clearButton: document.getElementById('clear-csv-input'),
        convertButton: document.getElementById('convert-json-button'),
        convertOverlay: document.getElementById('csv-convert-overlay'),
        convertLoading: document.getElementById('csv-convert-loading'),
        separatorSelect: document.getElementById('csv-separator'),
        sourceInput: document.getElementById('csv-source'),
        inlineError: document.getElementById('csv-inline-error'),
        rowCount: document.getElementById('csv-row-count'),
        columnCount: document.getElementById('csv-column-count'),
        delimiterLabel: document.getElementById('csv-delimiter-label'),
        issueChip: document.getElementById('csv-issue-chip'),
        issueChipCount: document.getElementById('csv-issue-chip-count'),
        inlinePreviewEmpty: document.getElementById('csv-inline-preview-empty'),
        inlinePreviewShell: document.getElementById('csv-inline-preview-shell'),
        inlinePreviewHead: document.getElementById('csv-inline-preview-head'),
        inlinePreviewBody: document.getElementById('csv-inline-preview-body'),
        previewEmpty: document.getElementById('csv-preview-empty'),
        previewLayout: document.getElementById('csv-preview-layout'),
        previewShell: document.getElementById('csv-preview-shell'),
        previewHead: document.getElementById('csv-preview-head'),
        previewBody: document.getElementById('csv-preview-body'),
        previewNote: document.getElementById('csv-preview-note'),
        previewPagination: document.getElementById('csv-preview-pagination'),
        previewPageSummary: document.getElementById('csv-preview-page-summary'),
        previewPageButtons: document.getElementById('csv-preview-page-buttons'),
        previewFirst: document.getElementById('csv-preview-first'),
        previewPrev: document.getElementById('csv-preview-prev'),
        previewNext: document.getElementById('csv-preview-next'),
        previewLast: document.getElementById('csv-preview-last'),
        previewModal: document.getElementById('csv-preview-modal'),
        previewModalBackdrop: document.getElementById('csv-preview-modal-backdrop'),
        closePreviewButton: document.getElementById('close-csv-preview'),
        formatButtons: Array.from(document.querySelectorAll('[data-json-format-option]')),
        jsonOutputState: document.getElementById('json-output-state'),
        jsonOutputEmpty: document.getElementById('json-output-empty'),
        jsonOutput: document.getElementById('json-output'),
        copyButton: document.getElementById('copy-json-output'),
        downloadButton: document.getElementById('download-json-output'),
        issueCount: document.getElementById('csv-issue-count'),
        issuesPanel: document.getElementById('csv-issues-panel'),
        issueSummary: document.getElementById('csv-issue-summary'),
        issuesList: document.getElementById('csv-issues-list'),
    };

    const state = {
        fileName: '',
        format: 'pretty',
        inputMode: 'upload',
        currentJson: '',
        hasHeader: true,
        previewColumns: [],
        previewRows: [],
        previewPage: 1,
        issues: [],
        errorRows: new Set(),
        lastParsedSource: '',
        lastParsedDelimiter: 'auto',
        lastFocusedElement: null,
        isConverting: false,
        liveConvertTimer: null,
    };

    const previewLimit = 10;
    const inlinePreviewLimit = 6;
    const dragActiveClasses = ['border-primary/60', 'bg-white', 'shadow-md'];

    const escapeHtml = (value) =>
        String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    const normalizeCell = (value) => String(value ?? '').replace(/^\uFEFF/, '').trim();

    const rowIsEmpty = (row) => row.every((cell) => normalizeCell(cell) === '');

    const detectHeaderRow = (rows) => {
        if (!rows.length) {
            return true;
        }

        const firstRow = rows[0].map(normalizeCell);

        if (!firstRow.length || firstRow.every((cell) => cell === '')) {
            return false;
        }

        const uniqueNonEmpty = firstRow.every(Boolean) && new Set(firstRow.map((cell) => cell.toLowerCase())).size === firstRow.length;
        const containsText = firstRow.some((cell) => /[A-Za-z]/.test(cell));
        const mostlyNumeric = firstRow.filter((cell) => /^[-+]?\d+(?:[.,]\d+)?$/.test(cell)).length >= Math.ceil(firstRow.length / 2);

        if (!uniqueNonEmpty || !containsText || mostlyNumeric) {
            return false;
        }

        if (rows.length === 1) {
            return true;
        }

        const secondRow = rows[1].map(normalizeCell);
        const secondHasValues = secondRow.some(Boolean);
        const sameShape = secondRow.every((cell, index) => cell.toLowerCase() === (firstRow[index] || '').toLowerCase());

        return secondHasValues && !sameShape;
    };

    const buildUniqueKeys = (headers) => {
        const usedKeys = new Map();

        return headers.map((header, index) => {
            const baseKey = normalizeCell(header).replace(/\s+/g, ' ') || `column_${index + 1}`;
            const normalizedKey = baseKey.trim() || `column_${index + 1}`;
            const counter = usedKeys.get(normalizedKey) || 0;

            usedKeys.set(normalizedKey, counter + 1);

            return counter === 0 ? normalizedKey : `${normalizedKey}_${counter + 1}`;
        });
    };

    const buildDelimiterLabel = (delimiter) => {
        if (!delimiter) {
            return 'Auto';
        }

        const map = {
            ',': 'Comma',
            ';': 'Semicolon',
            '\t': 'Tab',
            '|': 'Pipe',
        };

        return map[delimiter] || delimiter;
    };

    const clearInlineError = () => {
        refs.inlineError.textContent = '';
        refs.inlineError.classList.add('hidden');
    };

    const setInlineError = (message) => {
        if (!message) {
            clearInlineError();

            return;
        }

        refs.inlineError.textContent = message;
        refs.inlineError.classList.remove('hidden');
    };

    const setConversionLoading = (isLoading) => {
        state.isConverting = isLoading;

        refs.inputCard?.setAttribute('aria-busy', isLoading ? 'true' : 'false');

        if (refs.convertButton) {
            refs.convertButton.disabled = isLoading;
            refs.convertButton.setAttribute('aria-disabled', isLoading ? 'true' : 'false');
            refs.convertButton.innerHTML = isLoading
                ? 'Converting CSV... <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>'
                : 'Convert to JSON <i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i>';
        }

        if (refs.convertOverlay) {
            refs.convertOverlay.hidden = !isLoading;
            refs.convertOverlay.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
        }

        if (!refs.convertLoading) {
            return;
        }

        refs.convertLoading.hidden = !isLoading;
        refs.convertLoading.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
    };

    const updateFileBadge = () => {
        if (!state.fileName) {
            refs.fileBadge.textContent = '';
            refs.fileBadge.classList.add('hidden');
            refs.fileState?.classList.add('hidden');
            refs.fileStateName.textContent = '';

            return;
        }

        refs.fileBadge.textContent = state.fileName;
        refs.fileBadge.classList.remove('hidden');
        refs.fileStateName.textContent = state.fileName;
        refs.fileState?.classList.remove('hidden');
    };

    const setFormatButtonState = () => {
        refs.formatButtons.forEach((button) => {
            const isActive = button.dataset.jsonFormatOption === state.format;

            button.setAttribute('aria-pressed', String(isActive));
            button.classList.toggle('bg-primary', isActive);
            button.classList.toggle('text-white', isActive);
            button.classList.toggle('shadow-sm', isActive);
            button.classList.toggle('text-stone-700', !isActive);
            button.classList.toggle('hover:text-stone-900', !isActive);
        });
    };

    const setInputTabState = () => {
        refs.inputTabs.forEach((button) => {
            const isActive = button.dataset.csvInputTab === state.inputMode;

            button.setAttribute('aria-pressed', String(isActive));
            button.classList.toggle('bg-primary', isActive);
            button.classList.toggle('text-white', isActive);
            button.classList.toggle('shadow-sm', isActive);
            button.classList.toggle('text-stone-700', !isActive);
            button.classList.toggle('hover:text-stone-900', !isActive);
        });

        refs.inputPanels.forEach((panel) => {
            panel.classList.toggle('hidden', panel.dataset.csvInputPanel !== state.inputMode);
        });
    };

    const updateActionButtons = () => {
        const disabled = (refs.jsonOutput?.value || state.currentJson || '') === '';

        refs.copyButton.disabled = disabled;
        refs.downloadButton.disabled = disabled;
    };

    const updatePreviewButtonState = () => {
        const hasSource = Boolean(refs.sourceInput?.value?.trim());
        const hasPreview = state.previewColumns.length > 0;
        const shouldShow = hasSource || hasPreview;

        if (!refs.openPreviewButton) {
            return;
        }

        refs.openPreviewButton.classList.toggle('hidden', !shouldShow);
        refs.openPreviewButton.classList.toggle('inline-flex', shouldShow);
    };

    const openPreviewModal = () => {
        if (!refs.previewModal) {
            return;
        }

        state.lastFocusedElement = document.activeElement instanceof HTMLElement ? document.activeElement : null;
        refs.previewModal.classList.remove('hidden');
        refs.previewModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        refs.closePreviewButton?.focus();
    };

    const closePreviewModal = () => {
        if (!refs.previewModal || refs.previewModal.classList.contains('hidden')) {
            return;
        }

        refs.previewModal.classList.add('hidden');
        refs.previewModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
        state.lastFocusedElement?.focus?.();
    };

    const renderIssues = () => {
        refs.issueCount.textContent = `${state.issues.length} ${state.issues.length === 1 ? 'issue' : 'issues'}`;
        refs.issuesPanel?.classList.toggle('hidden', state.issues.length === 0);
        refs.previewLayout?.classList.toggle('xl:grid-cols-[minmax(0,1fr)_320px]', state.issues.length > 0);
        refs.issueChip?.classList.toggle('hidden', state.issues.length === 0);
        refs.issueChipCount.textContent = String(state.issues.length);

        if (!state.issues.length) {
            refs.issueSummary.textContent = refs.sourceInput.value.trim()
                ? 'No parsing issues found.'
                : 'No parsing issues yet. Upload a file or paste CSV text to validate it live.';
            refs.issuesList.innerHTML = '';

            return;
        }

        refs.issueSummary.textContent = 'We found CSV parsing issues. Highlighted rows in the preview need a quick review before export.';
        refs.issuesList.innerHTML = state.issues
            .slice(0, 6)
            .map((issue) => {
                const lineLabel = issue.lineNumber ? `Line ${issue.lineNumber}` : 'General';
                const codeLabel = issue.code ? ` (${issue.code})` : '';

                return `<li><span class="font-semibold text-red-800">${escapeHtml(lineLabel)}:</span> ${escapeHtml(issue.message)}${escapeHtml(codeLabel)}</li>`;
            })
            .join('');
    };

    const isValidCsvFile = (file) => {
        if (!file) {
            return false;
        }

        return file.name.toLowerCase().endsWith('.csv');
    };

    const rejectInvalidFile = () => {
        refs.fileInput.value = '';
        state.fileName = '';
        refs.sourceInput.value = '';
        updateFileBadge();
        resetState({ preserveError: true });
        setInlineError('Only CSV files are supported. Please upload a valid .csv file to continue.');
        window.ptNotify?.error?.('Only CSV files are supported. Please upload a valid .csv file to continue.');
    };

    const renderInlinePreview = () => {
        if (!state.previewColumns.length) {
            refs.inlinePreviewEmpty.classList.remove('hidden');
            refs.inlinePreviewShell.classList.add('hidden');
            refs.inlinePreviewHead.innerHTML = '';
            refs.inlinePreviewBody.innerHTML = '';

            return;
        }

        refs.inlinePreviewEmpty.classList.add('hidden');
        refs.inlinePreviewShell.classList.remove('hidden');

        refs.inlinePreviewHead.innerHTML = `
            <tr>
                <th scope="col" class="w-16 border-b border-stone-200/80 px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Row</th>
                ${state.previewColumns
                    .map((column) => `<th scope="col" class="border-b border-stone-200/80 px-3 py-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500"><span class="block max-w-[11rem] truncate" title="${escapeHtml(column)}">${escapeHtml(column)}</span></th>`)
                    .join('')}
            </tr>
        `;

        refs.inlinePreviewBody.innerHTML = state.previewRows
            .slice(0, inlinePreviewLimit)
            .map((row, index) => {
                const csvLineNumber = state.hasHeader ? index + 2 : index + 1;
                const rowClasses = state.errorRows.has(index)
                    ? 'bg-red-50/70'
                    : index % 2 === 0
                        ? 'bg-white'
                        : 'bg-stone-50/40';

                return `
                    <tr class="${rowClasses}">
                        <th scope="row" class="border-b border-stone-200/70 px-4 py-2.5 align-top text-[11px] font-semibold text-stone-500">${csvLineNumber}</th>
                        ${state.previewColumns
                            .map((_, columnIndex) => {
                                const value = escapeHtml(row[columnIndex] ?? '');

                                return `<td class="border-b border-stone-200/70 px-3 py-2.5 align-top text-[13px] leading-5 text-stone-700"><span class="block max-w-[11rem] truncate" title="${value}">${value || '&mdash;'}</span></td>`;
                            })
                            .join('')}
                    </tr>
                `;
            })
            .join('');
    };

    const renderPreview = () => {
        refs.rowCount.textContent = String(state.previewRows.length);
        refs.columnCount.textContent = String(state.previewColumns.length);
        const totalPages = Math.max(1, Math.ceil(state.previewRows.length / previewLimit));

        state.previewPage = Math.min(Math.max(state.previewPage, 1), totalPages);

        if (!state.previewColumns.length) {
            refs.previewEmpty.classList.remove('hidden');
            refs.previewShell.classList.add('hidden');
            refs.previewPagination.classList.add('hidden');
            refs.previewHead.innerHTML = '';
            refs.previewBody.innerHTML = '';
            refs.previewNote.textContent = '';
            renderInlinePreview();
            updatePreviewButtonState();

            return;
        }

        refs.previewEmpty.classList.add('hidden');
        refs.previewShell.classList.remove('hidden');

        refs.previewHead.innerHTML = `
            <tr>
                <th scope="col" class="sticky left-0 top-0 z-30 w-16 border-b border-stone-200/80 bg-stone-50/95 px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Row</th>
                ${state.previewColumns
                    .map(
                        (column) => `
                            <th scope="col" class="sticky top-0 z-20 border-b border-stone-200/80 bg-stone-50/95 px-3 py-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">
                                <span class="block max-w-[12rem] truncate" title="${escapeHtml(column)}">${escapeHtml(column)}</span>
                            </th>
                        `,
                    )
                    .join('')}
            </tr>
        `;

        if (!state.previewRows.length) {
            refs.previewPagination.classList.add('hidden');
            refs.previewBody.innerHTML = `
                <tr>
                    <td colspan="${state.previewColumns.length + 1}" class="px-4 py-6 text-center text-sm text-stone-500">
                        Headers were detected, but no data rows were found yet.
                    </td>
                </tr>
            `;
            refs.previewNote.textContent = '';
            renderInlinePreview();
            updatePreviewButtonState();

            return;
        }

        const startIndex = (state.previewPage - 1) * previewLimit;
        const endIndex = Math.min(startIndex + previewLimit, state.previewRows.length);

        refs.previewBody.innerHTML = state.previewRows
            .slice(startIndex, endIndex)
            .map((row, index) => {
                const absoluteIndex = startIndex + index;
                const csvLineNumber = state.hasHeader ? absoluteIndex + 2 : absoluteIndex + 1;
                const rowClasses = state.errorRows.has(absoluteIndex)
                    ? 'bg-red-50/80'
                    : absoluteIndex % 2 === 0
                        ? 'bg-white'
                        : 'bg-stone-50/55';

                return `
                    <tr class="${rowClasses} transition-colors hover:bg-primary/5">
                        <th scope="row" class="sticky left-0 z-10 border-b border-stone-200/70 bg-inherit px-4 py-2.5 align-top text-[11px] font-semibold text-stone-500">${csvLineNumber}</th>
                        ${state.previewColumns
                            .map((_, columnIndex) => {
                                const value = escapeHtml(row[columnIndex] ?? '');

                                return `
                                    <td class="border-b border-stone-200/70 px-3 py-2.5 align-top text-[13px] leading-5 text-stone-700">
                                        <span class="block max-w-[12rem] truncate" title="${value}">${value || '&mdash;'}</span>
                                    </td>
                                `;
                            })
                            .join('')}
                    </tr>
                `;
            })
            .join('');

        const pageButtons = [];
        const buttonStart = Math.max(1, state.previewPage - 1);
        const buttonEnd = Math.min(totalPages, buttonStart + 2);

        for (let page = buttonStart; page <= buttonEnd; page += 1) {
            const isActive = page === state.previewPage;

            pageButtons.push(`
                <button
                    type="button"
                    data-preview-page="${page}"
                    class="${isActive ? 'bg-primary text-white border-primary' : 'bg-white text-stone-600 border-stone-200/70 hover:border-primary/45 hover:text-stone-900'} inline-flex h-8 min-w-8 cursor-pointer items-center justify-center rounded-full border px-2 text-xs font-semibold transition">
                    ${page}
                </button>
            `);
        }

        refs.previewPagination.classList.toggle('hidden', state.previewRows.length <= previewLimit);
        refs.previewPageSummary.textContent = `Rows ${startIndex + 1}-${endIndex} of ${state.previewRows.length}`;
        refs.previewPageButtons.innerHTML = pageButtons.join('');
        refs.previewFirst.disabled = state.previewPage === 1;
        refs.previewPrev.disabled = state.previewPage === 1;
        refs.previewNext.disabled = state.previewPage === totalPages;
        refs.previewLast.disabled = state.previewPage === totalPages;

        refs.previewNote.textContent =
            state.previewRows.length > previewLimit
                ? `Page ${state.previewPage} of ${totalPages}.`
                : state.hasHeader
                    ? 'First row was treated as CSV headers automatically.'
                    : 'No clear header row was detected, so fallback column names are being used.';
        renderInlinePreview();
        updatePreviewButtonState();
    };

    const renderJsonOutput = (records) => {
        if (!records.length && !refs.sourceInput.value.trim()) {
            state.currentJson = '';
            refs.jsonOutput.value = '';
            refs.jsonOutput.classList.add('hidden');
            refs.jsonOutputEmpty.classList.remove('hidden');
            refs.jsonOutputState.textContent = '';
            updateActionButtons();

            return;
        }

        state.currentJson = JSON.stringify(records, null, state.format === 'pretty' ? 2 : 0);
        refs.jsonOutput.value = state.currentJson;
        refs.jsonOutput.classList.remove('hidden');
        refs.jsonOutputEmpty.classList.add('hidden');
        refs.jsonOutputState.textContent = records.length ? `${records.length} object${records.length === 1 ? '' : 's'}` : '';
        updateActionButtons();
    };

    const resetState = ({ preserveError = false } = {}) => {
        state.currentJson = '';
        state.hasHeader = true;
        state.previewColumns = [];
        state.previewRows = [];
        state.previewPage = 1;
        state.issues = [];
        state.errorRows = new Set();
        state.lastParsedSource = '';
        state.lastParsedDelimiter = 'auto';
        refs.delimiterLabel.textContent = 'Auto';
        if (!preserveError) {
            clearInlineError();
        }
        closePreviewModal();
        updateFileBadge();
        renderPreview();
        renderIssues();
        renderJsonOutput([]);
        updatePreviewButtonState();
    };

    const parseCsvInput = () => {
        const source = refs.sourceInput.value;
        const delimiterMap = {
            auto: '',
            comma: ',',
            semicolon: ';',
            tab: '\t',
            pipe: '|',
        };
        const selectedDelimiter = delimiterMap[refs.separatorSelect?.value || 'auto'] ?? '';

        clearInlineError();

        if (!source.trim()) {
            setInlineError('Paste CSV text or choose a CSV file before converting.');
            resetState({ preserveError: true });

            return;
        }

        const previewResult = Papa.parse(source, {
            delimiter: selectedDelimiter,
            skipEmptyLines: 'greedy',
        });

        const previewRows = previewResult.data
            .filter(Array.isArray)
            .map((row) => row.map(normalizeCell))
            .filter((row) => !rowIsEmpty(row));

        if (!previewRows.length) {
            setInlineError('No CSV rows were detected. Paste CSV text with comma, tab, semicolon, or pipe separators.');
            resetState({ preserveError: true });

            return;
        }

        state.hasHeader = detectHeaderRow(previewRows);

        const maxColumns = previewRows.reduce((highestCount, row) => Math.max(highestCount, row.length), 0);
        const rawHeaders = state.hasHeader ? [...previewRows[0]] : Array.from({ length: maxColumns }, (_, index) => `column_${index + 1}`);

        while (rawHeaders.length < maxColumns) {
            rawHeaders.push(`column_${rawHeaders.length + 1}`);
        }

        const objectKeys = buildUniqueKeys(rawHeaders);
        const bodyRows = state.hasHeader ? previewRows.slice(1) : previewRows;
        const normalizedBodyRows = bodyRows.map((row) => {
            const padded = [...row];

            while (padded.length < maxColumns) {
                padded.push('');
            }

            return padded;
        });

        const records = normalizedBodyRows
            .map((row) => {
                const entry = {};

                objectKeys.forEach((key, index) => {
                    const value = normalizeCell(row[index] ?? '');

                    entry[key] = value;
                });

                return entry;
            })
            .filter((entry) => Object.keys(entry).length > 0);

        state.errorRows = new Set();

        const uniqueIssueMap = new Map();

        previewResult.errors.forEach((issue, index) => {
            const rowIndex = Number.isInteger(issue.row) ? issue.row : null;
            const displayRow = rowIndex === null ? null : rowIndex - (state.hasHeader ? 1 : 0);
            const issueKey = `${issue.code}-${issue.message}-${rowIndex ?? 'general'}-${index}`;

            if (displayRow !== null && displayRow >= 0) {
                state.errorRows.add(displayRow);
            }

            uniqueIssueMap.set(issueKey, {
                code: issue.code || 'ParseIssue',
                message: issue.message || 'CSV parsing issue detected.',
                lineNumber: rowIndex === null ? null : rowIndex + 1,
            });
        });

        state.previewColumns = objectKeys;
        state.previewRows = normalizedBodyRows;
        state.previewPage = 1;
        state.issues = Array.from(uniqueIssueMap.values());
        state.lastParsedSource = source;
        state.lastParsedDelimiter = refs.separatorSelect?.value || 'auto';
        refs.delimiterLabel.textContent = buildDelimiterLabel(previewResult.meta.delimiter);

        renderPreview();
        renderIssues();
        renderJsonOutput(records);

        if (state.issues.length) {
            setInlineError('Some rows could not be parsed cleanly. Review the highlighted rows before using the JSON output.');
        }
    };

    const convertCsvInput = async () => {
        if (state.isConverting) {
            return;
        }

        setConversionLoading(true);

        await new Promise((resolve) => {
            window.requestAnimationFrame(() => {
                window.setTimeout(resolve, 0);
            });
        });

        try {
            parseCsvInput();
        } finally {
            setConversionLoading(false);
        }
    };

    const scheduleLiveConversion = () => {
        window.clearTimeout(state.liveConvertTimer);

        if (!refs.sourceInput.value.trim()) {
            resetState();

            return;
        }

        state.liveConvertTimer = window.setTimeout(() => {
            convertCsvInput();
        }, 180);
    };

    const reformatCurrentOutput = () => {
        const currentValue = refs.jsonOutput?.value?.trim();

        if (!currentValue) {
            return;
        }

        try {
            const parsed = JSON.parse(currentValue);

            state.currentJson = JSON.stringify(parsed, null, state.format === 'pretty' ? 2 : 0);
            refs.jsonOutput.value = state.currentJson;
            updateActionButtons();
        } catch (error) {
            // Leave edited/manual JSON untouched if it is no longer valid JSON.
        }
    };

    const readFile = async (file) => {
        if (!isValidCsvFile(file)) {
            rejectInvalidFile();

            return;
        }

        try {
            const contents = await file.text();

            state.fileName = file.name;
            state.inputMode = 'upload';
            setInputTabState();
            updateFileBadge();
            refs.sourceInput.value = contents;
            clearInlineError();
            updatePreviewButtonState();
            scheduleLiveConversion();
        } catch (error) {
            setInlineError('The selected file could not be read. Try another CSV file.');
            window.ptNotify?.error?.('Could not read the selected CSV file.');
        }
    };

    refs.fileInput?.addEventListener('change', (event) => {
        const [file] = event.target.files || [];

        if (file) {
            readFile(file);
        }
    });

    refs.clearButton?.addEventListener('click', () => {
        refs.sourceInput.value = '';
        refs.fileInput.value = '';
        state.fileName = '';
        state.inputMode = 'text';
        setInputTabState();
        updateFileBadge();
        resetState();
    });

    refs.sourceInput?.addEventListener('input', () => {
        updatePreviewButtonState();
        scheduleLiveConversion();
    });

    refs.separatorSelect?.addEventListener('change', () => {
        scheduleLiveConversion();
    });

    refs.formatButtons.forEach((button) => {
        button.addEventListener('click', () => {
            state.format = button.dataset.jsonFormatOption || 'pretty';
            setFormatButtonState();
            reformatCurrentOutput();
        });
    });

    refs.jsonOutput?.addEventListener('input', () => {
        state.currentJson = refs.jsonOutput.value;
        updateActionButtons();
    });

    refs.inputTabs.forEach((button) => {
        button.addEventListener('click', () => {
            state.inputMode = button.dataset.csvInputTab || 'upload';
            setInputTabState();
        });
    });

    refs.openPreviewButton?.addEventListener('click', async () => {
        const selectedDelimiter = refs.separatorSelect?.value || 'auto';
        const needsFreshParse =
            !state.previewColumns.length ||
            refs.sourceInput.value !== state.lastParsedSource ||
            selectedDelimiter !== state.lastParsedDelimiter;

        if (needsFreshParse) {
            await convertCsvInput();
        }

        if (!state.previewColumns.length) {
            return;
        }

        openPreviewModal();
    });

    refs.closePreviewButton?.addEventListener('click', () => {
        closePreviewModal();
    });

    refs.previewModalBackdrop?.addEventListener('click', () => {
        closePreviewModal();
    });

    refs.previewPrev?.addEventListener('click', () => {
        if (state.previewPage <= 1) {
            return;
        }

        state.previewPage -= 1;
        renderPreview();
    });

    refs.previewFirst?.addEventListener('click', () => {
        if (state.previewPage === 1) {
            return;
        }

        state.previewPage = 1;
        renderPreview();
    });

    refs.previewNext?.addEventListener('click', () => {
        const totalPages = Math.max(1, Math.ceil(state.previewRows.length / previewLimit));

        if (state.previewPage >= totalPages) {
            return;
        }

        state.previewPage += 1;
        renderPreview();
    });

    refs.previewLast?.addEventListener('click', () => {
        const totalPages = Math.max(1, Math.ceil(state.previewRows.length / previewLimit));

        if (state.previewPage === totalPages) {
            return;
        }

        state.previewPage = totalPages;
        renderPreview();
    });

    refs.previewPageButtons?.addEventListener('click', (event) => {
        const target = event.target instanceof HTMLElement ? event.target.closest('[data-preview-page]') : null;

        if (!target) {
            return;
        }

        const nextPage = Number(target.getAttribute('data-preview-page'));

        if (!Number.isInteger(nextPage) || nextPage < 1) {
            return;
        }

        state.previewPage = nextPage;
        renderPreview();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closePreviewModal();
        }
    });

    refs.copyButton?.addEventListener('click', async () => {
        const jsonText = refs.jsonOutput?.value || state.currentJson;

        if (!jsonText) {
            return;
        }

        try {
            if (navigator.clipboard?.writeText && window.isSecureContext) {
                await navigator.clipboard.writeText(jsonText);
            } else {
                refs.jsonOutput?.focus();
                refs.jsonOutput?.select();
                refs.jsonOutput?.setSelectionRange(0, jsonText.length);

                const copied = document.execCommand('copy');

                if (!copied) {
                    throw new Error('execCommand copy failed');
                }
            }

            window.ptNotify?.success?.('JSON copied to clipboard.');
        } catch (error) {
            refs.jsonOutput?.focus();
            refs.jsonOutput?.select();
            refs.jsonOutput?.setSelectionRange(0, jsonText.length);
            window.ptNotify?.error?.('Copy failed. Press Ctrl+C after selecting the JSON.');
        }
    });

    refs.downloadButton?.addEventListener('click', () => {
        const jsonText = refs.jsonOutput?.value || state.currentJson;

        if (!jsonText) {
            return;
        }

        const blob = new Blob([jsonText], { type: 'application/json;charset=utf-8' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        const baseName = state.fileName ? state.fileName.replace(/\.csv$/i, '') : 'csv-to-json-output';

        link.href = url;
        link.download = `${baseName || 'csv-to-json-output'}.json`;
        document.body.appendChild(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
    });

    ['dragenter', 'dragover'].forEach((eventName) => {
        refs.dropzone?.addEventListener(eventName, (event) => {
            event.preventDefault();
            refs.dropzone.classList.add(...dragActiveClasses);
        });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
        refs.dropzone?.addEventListener(eventName, (event) => {
            event.preventDefault();
            refs.dropzone.classList.remove(...dragActiveClasses);
        });
    });

    refs.dropzone?.addEventListener('drop', (event) => {
        const [file] = event.dataTransfer?.files || [];

        if (file) {
            readFile(file);
        }
    });

    refs.replaceFileButton?.addEventListener('click', () => {
        refs.fileInput?.click();
    });

    refs.removeFileButton?.addEventListener('click', () => {
        refs.fileInput.value = '';
        refs.sourceInput.value = '';
        state.fileName = '';
        state.inputMode = 'upload';
        setInputTabState();
        updateFileBadge();
        resetState();
    });

    setFormatButtonState();
    setInputTabState();
    setConversionLoading(false);
    resetState();
}
