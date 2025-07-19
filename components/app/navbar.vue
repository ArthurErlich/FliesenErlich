<template>
	<header class="">
		<nav class="">
			<ul class="">
				<li>
					<NuxtLink :to="{ name: 'index' }">
						<NuxtImg
							src="/logo/logo-erlich.png"
							format="png"
							alt="Erlich Fliesen Logo"
							preload
							fit="inside"
							class="logo"
						/>
					</NuxtLink>
				</li>
			</ul>
			<ul class="nav-links">
				<li>
					<NuxtLink :to="{ name: 'index' }">Startseite</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'fliesen-erlich' }">Fliesen-Erlich</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'blog' }">Blog</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'kontakt' }">Kontakt</NuxtLink>
				</li>
			</ul>
		</nav>
	</header>
</template>

<style scoped>
header {
	padding: 5px;
	position: sticky;
	top: 0;
	left: 0;
	background-color: var(--erlich-white);
}

nav {
	display: flex;
	justify-content: space-between;
	margin: auto;
}
.nav-links{
	width: 450px;
	justify-content: space-evenly;
}

a {
	color: var(--erlich-black);
	text-decoration: none;
}

a:hover {
	color: var(--erlich-black);

}

ul {
	/* list-none flex gap-2  items-center */
	list-style: none;
	align-items: center;
	gap: 5px;
	display: flex;
	margin: 0;
	padding: 0;
}

li {
	display: inline;
	margin: 0;
}

.logo {
	height: 25pt;
}
</style>
