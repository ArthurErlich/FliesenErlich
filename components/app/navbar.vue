<template>
	<header class="pt-2 pb-2 bg-erlich sticky top-0 left-0">
		<nav class="flex justify-between container mx-auto ">
			<ul class="list-none flex gap-2  items-center">
				<li>
					<NuxtLink :to="{ name: 'index' }">
						<NuxtImg
							src="/logo/logo-erlich.png"
							format="png"
							alt="Erlich Fliesen Logo"
							preload
							fit="inside"
							class="h-10"
						/>
					</NuxtLink>
				</li>
			</ul>
			<ul class="list-none flex gap-2 items-center">
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
