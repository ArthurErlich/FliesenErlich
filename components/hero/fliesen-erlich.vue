<template>
	<div
		ref="hero"
		class="hero-container"
	>
		<div class="wrapper">
			<div class="text">
				<h2 class="px-0 mx-0">
					Fliesen Erlich
				</h2>
				<h3 class="px-0 mx-0">
					Wenn die Qualität stimmen muss!
				</h3>
			</div>
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
	height: 100vh;
	background-color: gray;
	background-image: url(/hero/15.41.26_ad8dc9dc.jpg);
	background-size: cover;

	display: flex;
	justify-content: center;
	align-items: center;

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
	background-color: rgba(255, 255, 255, 0.419);
	/* opacity: 0.2; */
}
</style>
