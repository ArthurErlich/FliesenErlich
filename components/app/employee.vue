<template>
	<div class="emploee">
		<NuxtImg
			:src="src"
			:alt="name"
			preload
			class="faceshoot"
		/>
		<h3 v-text="name" />
		<p v-text="moto" />
	</div>
</template>

<script lang="ts">
export default {
	props: {
		src: {
			type: String,
			default: "",
		},
		name: {
			type: String,
			default: "Max Mustermann",
		},
		moto: {
			type: String,
			default: "Best Emploee of the world!",
		},
	},
};
</script>

<style scoped>
.emploee {
	max-width: 250px;
	text-align: center;
	word-break: keep-all;
}

.faceshoot {
	background-color: gray;
	border-radius: 100%;
	width: 150px;
	height: 150px;
	object-fit: cover;
}
</style>
