<template>
	<div>
		<label :for="id">{{ label }}</label>
		<span
			v-if="required"
			aria-hidden="true"
		>*</span>
		<input
			:id="id"
			:v-model="modelValue"
			:type="type"
			:name="name"
			:required="required"
			@input="$emit('update:modelValue', $event.target.value)"
		>
	</div>
</template>

<script>
export default {
	name: "FormInput",
	props: {
		modelValue: {
			type: String,
			default: "",
		},
		id: {
			type: String,
			required: true,
		},
		label: {
			type: String,
			required: true,
		},
		type: {
			type: String,
			default: "text",
		},
		name: {
			type: String,
			required: true,
		},
		required: {
			type: Boolean,
			default: false,
		},
	},
};
</script>
