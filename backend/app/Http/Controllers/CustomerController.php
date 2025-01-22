<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseBuilder;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/*
 * @group Customers
 */
class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {
    }

    /**
     * Get Customers
     *
     * Retrieve a paginated list of customers. You can filter customers by providing query parameters in the request.
     *
     * @queryParam per_page int Number of customers per page. Defaults to 10. Example: 15
     * @queryParam filters array Filters to apply to the customer list. Example: {"name": "John Doe"}
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "customers": [
     *       {
     *         "id": 1,
     *         "name": "John Doe",
     *         "phone": "+1 234 555 66 77",
     *         "email": "john.doe@example.com",
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 10,
     *     "total": 1,
     *     "has_next": false
     *   }
     * }
     * @responseField customers[] The list of customers.
     * @responseField customers[].id The ID of the customer.
     * @responseField customers[].name The name of the customer.
     * @responseField customers[].name The phone number of the customer.
     * @responseField customers[].email The email address of the customer.
     * @responseField current_page The current page of the pagination.
     * @responseField per_page The number of items per page.
     * @responseField total The total number of customers.
     * @responseField has_next Whether there are more pages of customers.
     */
    public function index(Request $request): JsonResponse
    {
        $customers = $this->customerService->getPaginatedCustomers(
            $request->per_page ?? 10,
            $request->filters ?? []
        );

        return ResponseBuilder::success(
            data: [
                'customers' => CustomerResource::collection($customers),
                'current_page' => $customers->currentPage(),
                'per_page' => $customers->perPage(),
                'total' => $customers->total(),
                'has_next' => $customers->hasMorePages(),
            ]
        );
    }

    /**
     * Create a Customer
     *
     * Create a new customer in the system.
     *
     * @bodyParam name string required The name of the customer. Example: John Doe
     * @bodyParam email string required The email address of the customer. Example: john.doe@example.com
     *
     * @response 201 {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "john.doe@example.com",
     *   "phone": "+1 234 555 66 77",
     * }
     * @responseField id The ID of the customer.
     * @responseField name The name of the customer.
     * @responseField email The email address of the customer.
     * @responseField created_at The creation timestamp of the customer.
     * @responseField updated_at The last update timestamp of the customer.
     */
    public function store(StoreCustomerRequest $request): Customer
    {
        return $this->customerService
            ->createCustomer($request->validated());
    }
}
