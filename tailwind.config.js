export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            colors: {
                primary: "#C6862D",
                accent: "#4A7C44",
                "potato-beige": "#FAF1E6",
                "potato-dark": "#D9C5B2",
            },
            fontFamily: {
                sans: ["Quicksand", "sans-serif"],
                display: ["Fredoka", "sans-serif"],
            },
            container: {
                center: true,
                padding: "1rem",
            },
        },
    },
    plugins: [],
};
