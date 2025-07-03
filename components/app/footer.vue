<template>
	<div class="footer-container pt-2 pb-2">
		<footer class="container mx-auto">
			<ul class="list-none flex gap-2">
				<li>
					<NuxtLink :to="{ name: 'kontakt' }">Kontakt</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'impressum' }">Impressum</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'datensschutz' }">Datensschutz</NuxtLink>
				</li>
			</ul>
		</footer>
	</div>
</template>
