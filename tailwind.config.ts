import type { Config } from "tailwindcss";

const config: Config = {
	content: [
		"./components/**/*.{vue,js,ts}",
		"./layouts/**/*.vue",
		"./pages/**/*.vue",
		"./app.vue",
		"./plugins/**/*.{js,ts}",
	],
	theme: {
		extend: {
			colors: {
				erlich: {
					DEFAULT: "#822C2A", // Hauptrot
					light: "#A13A35", // Hoverrot
					pale: "#E6E6E6", // Hellgrau
					white: "#F2F2F2", // leicht getöntes Weiß
					black: "#000000", // Standardtext
					accent: "#B08C6B", // Kupfer-Gold Akzent
					accentHover: "#C7A481", // Hover für Akzent
				},
			},
			fontFamily: {
				// serif: ["\"Playfair Display\"", "serif"],
				// sans: ["\"Inter\"", "sans-serif"],
			},
			borderRadius: {
			// 	"xl": "1rem",
			// 	"2xl": "1.5rem",
			},
		},
	},
	plugins: [],
};
export default config;
