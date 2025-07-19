<template>
	<div>
		<AppNavbar ref="nav" />
		<main ref="main">
			<slot />
		</main>
		<AppFooter ref="footer" />
	</div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";

const nav = ref<{ el: HTMLElement } | null>(null);
const main = ref<HTMLElement | null>(null);
const footer = ref<{ el: HTMLElement } | null>(null);

onMounted(() => {
	const navHeight = nav.value?.el.getBoundingClientRect().height ?? 0;
	const footerHeight = footer.value?.el.getBoundingClientRect().height ?? 0;
	const htmlElement = document.getElementsByTagName("html")[0];
	console.log(navHeight, footerHeight);

	if (main.value && htmlElement) {
		main.value.style.minHeight = (htmlElement.clientHeight - (navHeight + footerHeight) - 0.2) + "px";
	}
});
</script>

<style>
main{
	min-height: 0px;
}
</style>
