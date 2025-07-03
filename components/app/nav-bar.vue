<template>
	<header class="pt-2 pb-2 border-1">
		<nav class="flex justify-between container mx-auto">
			<ul class="list-none flex gap-2  items-center">
				<li>
					<NuxtLink :to="{ name: 'index' }">
						<NuxtImg
							src="/logo/logo-erlich.png"
							alt="Erlich Fliesen Logo"
							preload
							fit="inside"
							class="h-10"
						/>
					</NuxtLink>
				</li>
			</ul>
			<ul class="flex items-center">
				<li class="font-bold">
					Erlich Fliesen
				</li>
			</ul>
			<ul class="list-none flex gap-2 items-center">
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
