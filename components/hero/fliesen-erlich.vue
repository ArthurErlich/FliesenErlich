<template>
	<div
		ref="hero"
		class="hero-container"
	>
		<div class="wrapper">
			<div class="text">
				<h1 class="px-0 mx-0">
					Fliesen Erlich
				</h1>
				<h2 class="px-0 mx-0">
					Wenn die Qualität stimmen muss!
				</h2>
			</div>
		</div>
		<div class="scroll-icon-wrapper">
			Scroll
		</div>
	</div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";

const hero = ref<HTMLElement | null>(null);

let calcHeight = 0;
// const navElement: HTMLElement | null = document.getElementsByTagName("nav")[0];
// calcHeight = screen.height - (navElement.scrollHeight + footerElement.scrollHeight);

// heroRef.value?.style.height = calcHeight + "px";
onMounted(() => {
	// Access the DOM element after it mounts

	// calc height of window - navelement height
	// nav is a component
	calcHeight = window.innerHeight - 47.33; // actual navbar heigt.
	if (hero.value) {
		hero.value.style.height = calcHeight + "px";
	}
});
</script>

<style scoped>
.hero-container {
	padding: 0;
	margin: 0;
	height: 90vh;
	background-color: gray;
	background-image: url(/media/hero/15.41.26_ad8dc9dc.jpg);
	background-size: cover;
	flex-wrap: wrap;
	display: flex;
	justify-content: end;
	align-items: center;
	transition: height 0.1s ease-in-out;

}

.text {
	border-radius: 2px;
	padding-left: 10px;
	padding-right: 10px;
}

.wrapper {
	padding-right: 50%;
	width: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	height: 200px;
	background-color: rgba(255, 255, 255, 0.601);
	/* opacity: 0.2; */
}
.scroll-icon-wrapper{
	--margin: 10px;
	--size:80px;
	width: var(--size);
	height: var(--size);
	background-color: white;
	align-self: flex-end;
	text-align: center;
	border-radius: 100%;
	margin-right: var(--margin);
	margin-bottom: var(--margin);

	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;

}
</style>
