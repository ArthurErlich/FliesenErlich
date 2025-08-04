<template>
	<header
		ref="root"
		class=""
	>
		<nav class="desk-nav">
			<ul class="nav-logo">
				<li>
					<NuxtLink :to="{ name: 'index' }">
						<NuxtImg
							src="/media/logo/logo-erlich.png"
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
				<li v-if="false">
					<NuxtLink :to="{ name: 'blog' }">Blog</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'kontakt' }">Kontakt</NuxtLink>
				</li>
			</ul>
		</nav>
		<nav class="mob-nav">
			<button
				class="toggle"
				@click="toggleHamburger"
			>
				X
			</button>
			<div
				class="hamburger"
				:style="{ marginRight: isOpen ? '0px' : '0px' }"
			>
				<ul
					class="mob-links"
					:style="{ width: isOpen ? '250px' : '0px' }"
				>
					<li>
						<NuxtLink :to="{ name: 'index' }">Startseite</NuxtLink>
					</li>
					<li>
						<NuxtLink :to="{ name: 'fliesen-erlich' }">Fliesen-Erlich</NuxtLink>
					</li>
					<li v-if="false">
						<NuxtLink :to="{ name: 'blog' }">Blog</NuxtLink>
					</li>
					<li>
						<NuxtLink :to="{ name: 'kontakt' }">Kontakt</NuxtLink>
					</li>
				</ul>
			</div>
		</nav>
	</header>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const root = ref<HTMLElement | null>(null);

// This makes the DOM ref accessible to the parent
defineExpose({
	el: root,
});

const isOpen = ref(false);

const toggleHamburger = () => {
	isOpen.value = !isOpen.value;
};
</script>

<style>
header {
	padding: 5px;
	position: sticky;
	top: 0;
	left: 0;
	background-color: var(--erlich-white);
}

header>nav {
	display: flex;
	justify-content: space-between;
	margin: auto;
	height: 37.33px;
}

/* .nav-links {
	width: 450px;
	justify-content: space-evenly;
} */

.nav-links a:hover,
.mob-links a:hover {
	background-color: var(--erlich-light);
	border-radius: 1px;
	color: var(--erlich-white);

}

.nav-links>li {
	height: 100%;
}

.nav-links a,
nav > a,
.mob-links a {
	display: flex;
	align-items: center;
	height: 100%;
	padding-left: 5px;
	padding-right: 5px;
	color: var(--erlich-black);
	text-decoration: none;

	transition: color 0.1s ease-in-out;
	transition: background-color 0.1s ease-in-out;

}

header ul {
	/* list-none flex gap-2  items-center */
	list-style: none;
	align-items: center;
	gap: 5px;
	display: flex;
	margin: 0;
	padding: 0;
}

header li {
	display: inline;
	margin: 0;
	overflow: none;
}

.logo {
	height: 25pt;
}

/* do this in javascript, better for screen reader e.g accessibility */
.mob-nav {
	display: none;
}

@media (max-width: 767px) {

	.desk-nav {
		display: none;
	}
	.header{
		display: block;
	}
	.mob-nav {
		display: block;
	}
}
.mob-nav{
	margin-left: auto;
}
.mob-links{
	display: flex;
	flex-direction: column;
	/* width: 250px; */
	background-color: var(--erlich-white);
	/* margin-left: 25px; */
	padding-top: 25px;
	padding-bottom: 25px;
	overflow:hidden;
	transition: width 0.25s ease-in-out;
	overflow: hidden;
	word-break: keep-all;
	/* height:120px; */

}
.mob-links > li{
	gap: 5px;
	margin:	5px
}
.hamburger{
	position:absolute;
	right:0;
	z-index: 10;
	padding-top: 5px;
	/* width: 50px; */
	transition: margin-right 0.25s ease-in-out;
	/* overflow:hidden */
}
.toggle{
	margin-top: 5px;
	width: 25px;
	height: 25px;
	display: flex;
	align-items: center;
	justify-content: center;
	border: none;
	margin-left: auto;
}
</style>
