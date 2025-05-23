## 🚧 Next Version Roadmap

The upcoming version of this package will include several improvements to enhance developer experience and API consistency:

- ✅ **Auto-detect Laravel API Resources or Collections** and wrap them automatically in success responses.
- ✅ **`paginated()` method** to format paginated API responses with meta information like `current_page`, `total`, `per_page`, etc.
- ✅ **Debug mode support** (toggled via `.env`) to include exception trace info in error responses (local/dev environments only).
- ✅ **Laravel localization integration** using `__()` helper for translatable response messages.
- ✅ **Predefined constants or enums** for HTTP status codes, e.g., `self::NOT_FOUND`, `self::CREATED`, for cleaner syntax.
- ✅ **Static testing helpers** like `HttpResponse::mockSuccess()` and `mockError()` for writing cleaner API tests.
- ✅ **Macro support** to enable `response()->success($data)` and `response()->error($message)` via Laravel service provider.
- ✅ **Response-wrapping middleware** that auto-converts all controller return data into standardized API formats (unless opted out).
- ✅ **Optional JSON:API compatible output mode**, supporting `{ data: ..., errors: ..., meta: ... }` structure for advanced clients.

> feedback, and ideas are welcome
 **NB:** This package is primarily built for **my personal use**.
