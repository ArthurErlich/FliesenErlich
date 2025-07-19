<template>
	<div class="container">
		<h1>Unsere Philosophie</h1>
		<h2>Das Fliesen Erlich Team</h2>
		<div class="employees">
			<AppEmployee
				src="/media/employees/waldemar-erlich.jpg"
				name="Waldemar Erlich"
				moto="Leidenschaftlicher Angler und der richtige Ansprechpartner wenne es um Fliesen geht."
			/>
			<AppEmployee
				src="/media/employees/waldemar-erlich.jpg"
				name="Waldemar Erlich"
				moto="Leidenschaftlicher Angler und der richtige Ansprechpartner wenne es um Fliesen geht."
			/>
			<AppEmployee
				src="/media/employees/waldemar-erlich.jpg"
				name="Waldemar Erlich"
				moto="Leidenschaftlicher Angler und der richtige Ansprechpartner wenne es um Fliesen geht."
			/>
		</div>
	</div>
</template>

<script lang="ts" setup>

</script>

<style>
.employees{
	display: flex;
	align-items: baseline;
	flex-wrap: wrap;
	justify-content: space-evenly;
}
h1{
	margin-top: 0;
}
</style>
