// Typed wrapper for the "contact" key. Matching PHP handler:
// public/api/src/Handlers/ContactHandler.php

import { callApi, type ApiResponse } from './client';

export interface ContactFormData {
	name: string;
	email: string;
	message: string;
	'cap-token': string;
}

export function submitContactForm(data: ContactFormData): Promise<ApiResponse> {
	return callApi('contact', data);
}
