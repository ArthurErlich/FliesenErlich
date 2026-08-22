// @ts-check
import { defineConfig, fontProviders } from 'astro/config';

import sitemap from '@astrojs/sitemap';

import icon from 'astro-icon';

import markdoc from '@astrojs/markdoc';

import mdx from '@astrojs/mdx';

import llms from 'astro-llms-md';

import tailwindcss from '@tailwindcss/vite';

import sentry from '@sentry/astro';

// https://astro.build/config
export default defineConfig({
  site: process.env.SITE_URL ?? 'http://localhost.de',
  trailingSlash: 'always',
  integrations: [sitemap(), icon(), markdoc(), mdx(), llms(), sentry()],

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