// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
	appId: "Fliesen-Erlich",
	modules: [
		"@nuxt/eslint",
		"@nuxt/icon",
		"@nuxt/image",
		"@nuxtjs/seo",
		// "@nuxtjs/tailwindcss",
		// "@nuxt/content",
	],
	devtools: { enabled: true },
	app: {
		head: {
			link: [
				{ rel: "icon", type: "image/png", href: "/media/favicon/erlich-fliesen-favicon-64.png" },
				{ rel: "icon", type: "image/png", href: "/media/favicon/erlich-fliesen-favicon.png" },
				// do this for each page with dynamic config { rel: "preload" },
			],
			htmlAttrs: {
				lang: "de",
			},
		},
		pageTransition: { name: "page", mode: "out-in" },
	},
	css: [
		"~/assets/css/main.css",
	],
	vue: {
		compilerOptions: {
			isCustomElement: (tag) => {
				return ["section"].includes(tag);
			},
		},
	},
	sourcemap: {
		server: true,
		client: true,
	},
	compatibilityDate: "2025-05-15",
	typescript: {
		typeCheck: true,
	},
	eslint: {
		config: {
			stylistic: {
				semi: true,
				quotes: "double",
				commaDangle: "always-multiline",
				indent: "tab",
			},
		},
	},
	// tailwindcss: {
	// 	// cssPath: [`assets/css/tailwind.css`, { injectPosition: "first" }],
	// 	editorSupport: true,
	// 	configPath: "tailwind.config.js",
	// 	// config: { tailwindConfig: "tailwind.config.js" },
	// 	viewer: true,
	// 	exposeConfig: true,
	// },
});
