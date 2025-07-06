<template>
	<div class="pt-2 pb-2">
		<footer class="container mx-auto ">
			<ul class="list-none flex gap-4">
				<li>
					<NuxtLink :to="{ name: 'kontakt' }">Kontakt</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-impressum' }">Impressum</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-datensschutz' }">Datensschutz</NuxtLink>
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

<style>

</style>
