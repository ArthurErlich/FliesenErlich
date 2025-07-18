<template>
	<div class="footer-wrapper">
		<footer class="container">
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
		</footer>
	</div>
</template>

<script lang="ts" setup>

</script>

<style scoped>
.footer-wraper {
	padding: 5px;
}

.footer-wrapper {
	background-color: var(--erlich-default);
}

footer {
	height: 50px;
	display: flex;
	justify-content: baseline;
	margin: auto;
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
