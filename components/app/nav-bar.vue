<template>
	<header class="container">
		<nav>
			<ul>
				<li><strong>Erlich Fliesen</strong></li>
			</ul>
			<ul>
				<li>
					<NuxtLink :to="{ name: 'index' }">Startseite</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'portfolio' }">Portfolio</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'referenzen' }">Referenzen</NuxtLink>
				</li>
			</ul>
		</nav>
	</header>
</template>
