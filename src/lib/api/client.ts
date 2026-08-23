// Client for the single JSON API endpoint at public/api/index.php.
// Every request is {"key": "<form name>", "data": {...}} — new forms add a
// typed wrapper (see contact.ts) that calls callApi() with a new key,
// never a new API endpoint. Matching PHP: public/api/src/Dispatcher.php.

export interface ApiRequest<TKey extends string, TData> {
  key: TKey;
  data: TData;
}

export interface ApiResponse<TData = Record<string, never>> {
  success: boolean;
  error?: string;
  data?: TData;
}

export async function callApi<TKey extends string, TReqData, TResData = Record<string, never>>(
  key: TKey,
  data: TReqData,
): Promise<ApiResponse<TResData>> {
  const res = await fetch("/api/index.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ key, data } satisfies ApiRequest<TKey, TReqData>),
  });
  return res.json() as Promise<ApiResponse<TResData>>;
}
