<template>
	<footer
		ref="root"
		class=""
	>
		<div class="container footer-wraper">
			<ul class="list-none flex gap-4">
				<li>
					<NuxtLink :to="{ name: 'kontakt' }">Kontakt</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-impressum' }">Impressum</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-datenschutz' }">Datenschutz</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-cookies' }">Cookies</NuxtLink>
				</li>
			</ul>
		</div>
	</footer>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const root = ref<HTMLElement | null>(null);

// This makes the DOM ref accessible to the parent
defineExpose({
	el: root,
});
</script>

<style scoped>
.footer-wraper {
	padding: 5px;
}

.footer-wrapper {
	height: 50px;
	display: flex;
	justify-content: baseline;
	margin: auto;
}

footer {
	background-color: var(--erlich-default);
}

ul {
	width: 100%;
	list-style: none;
	align-items: center;
	justify-content: space-between;
	gap: 5px;
	display: flex;
	padding: 0;
}

li {
	display: inline;
	margin: 0;
}

a {
	color: var(--erlich-white);
	text-decoration: none;
}

a:hover {
	color: var(--erlich-white);

}
</style>
