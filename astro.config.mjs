// @ts-check
import { defineConfig, fontProviders } from 'astro/config';

import sitemap from '@astrojs/sitemap';

import icon from 'astro-icon';

import tailwindcss from '@tailwindcss/vite';

// https://astro.build/config
export default defineConfig({
  site: process.env.SITE_URL ?? 'https://erlich-fliesen.de',
  trailingSlash: 'always',
  integrations: [sitemap(), icon()],

  vite: {
    plugins: [tailwindcss()]
  },

  fonts: [
    {
      name: 'Yeseva One',
      cssVariable: '--font-yeseva-one',
      provider: fontProviders.fontsource()
    },
    {
      name: 'Noto Serif',
      cssVariable: '--font-noto-serif',
      provider: fontProviders.fontsource(),
      weights: [400, 600, 700],
      styles: ['normal', 'italic']
    },
    {
      name: 'Inter',
      cssVariable: '--font-inter',
      provider: fontProviders.fontsource(),
      weights: [400, 500, 600, 700]
    }
  ],

  server: {
    port: 5500
  }
});