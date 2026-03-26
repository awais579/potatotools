import './bootstrap';
import { Notyf } from 'notyf';
import flatpickr from 'flatpickr';
import SlimSelect from 'slim-select';
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

const notyf = new Notyf({
    duration: 3800,
    ripple: false,
    dismissible: true,
    position: {
        x: 'right',
        y: 'top',
    },
    types: [
        {
            type: 'success',
            className: 'pt-toast-success',
            background: '#ffffff',
            icon: false,
        },
        {
            type: 'error',
            className: 'pt-toast-error',
            background: '#ffffff',
            icon: false,
        },
    ],
});

let activeNotification = null;

const showToast = (type, message, options = {}) => {
    if (!message) {
        return null;
    }

    if (activeNotification) {
        notyf.dismiss(activeNotification);
        activeNotification = null;
    }

    activeNotification = notyf.open({
        type,
        message,
        dismissible: options.dismissible ?? true,
        duration: options.duration,
    });

    return activeNotification;
};

window.ptNotify = {
    success(message, options = {}) {
        return showToast('success', message, options);
    },
    error(message, options = {}) {
        return showToast('error', message, options);
    },
    dismissCurrent() {
        if (!activeNotification) {
            return;
        }

        notyf.dismiss(activeNotification);
        activeNotification = null;
    },
};

const tooltipNodes = document.querySelectorAll('[data-pt-tooltip]');

if (tooltipNodes.length) {
    tippy(tooltipNodes, {
        allowHTML: false,
        animation: 'fade',
        content(reference) {
            return reference.getAttribute('data-pt-tooltip') || '';
        },
        delay: [80, 40],
        duration: [180, 120],
        maxWidth: 260,
        placement: 'top',
        theme: 'pt-light',
    });
}

const datepickerNodes = document.querySelectorAll('[data-pt-datepicker]');

if (datepickerNodes.length) {
    datepickerNodes.forEach((node) => {
        flatpickr(node, {
            allowInput: false,
            clickOpens: true,
            dateFormat: 'd/m/Y',
            disableMobile: true,
            nextArrow: '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>',
            prevArrow: '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>',
            defaultDate: node.dataset.ptDatepickerDefault || undefined,
        });
    });
}

document.querySelectorAll('[data-pt-datepicker-open]').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.ptDatepickerOpen || '');

        input?._flatpickr?.open();
    });
});

const initializePtSelect = (node) => {
    if (!node || node.dataset.ptSelectInitialized === 'true') {
        return node?._ptSlimSelect || null;
    }

    const slimSelect = new SlimSelect({
        select: node,
        settings: {
            showSearch: node.dataset.ptSelectSearch === 'true',
            searchPlaceholder: 'Search...',
            searchText: 'No results found',
            closeOnSelect: true,
            contentLocation: document.body,
            contentPosition: 'absolute',
        },
    });

    node.dataset.ptSelectInitialized = 'true';
    node._ptSlimSelect = slimSelect;

    return slimSelect;
};

window.ptInitSelect = initializePtSelect;

const selectNodes = document.querySelectorAll('[data-pt-select]');

if (selectNodes.length) {
    selectNodes.forEach((node) => {
        initializePtSelect(node);
    });
}
