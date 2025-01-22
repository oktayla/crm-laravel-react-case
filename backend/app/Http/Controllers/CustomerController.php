<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseBuilder;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Customers
 */
class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {}

    /**
     * Get Customers
     *
     * Retrieve a paginated list of customers. You can filter customers by providing query parameters in the request.
     *
     * @authenticated
     *
     * @queryParam per_page int Number of customers per page. Defaults to 10. Example: 15
     * @queryParam filters[first_name] string Filter by the customer's first name. Example: John
     * @queryParam filters[last_name] string Filter by the customer's last name. Example: Doe
     * @queryParam filters[phone] string Filter by the customer's phone number. Example: +1 234 555 66 77
     * @queryParam filters[email] string Filter by the customer's email address. Example: john.doe@example.com
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "customers": [
     *       {
     *         "id": 1,
     *         "first_name": "John",
     *         "last_name": "Doe",
     *         "phone": "+1 234 555 66 77",
     *         "email": "john.doe@example.com"
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
     * @responseField customers[].first_name The first name of the customer.
     * @responseField customers[].last_name The last name of the customer.
     * @responseField customers[].phone The phone number of the customer.
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
     * @bodyParam first_name string required The first name of the customer. Example: John
     * @bodyParam last_name string required The last name of the customer. Example: Doe
     * @bodyParam phone string required The phone number of the customer. Example: +1 234 555 66 77
     * @bodyParam email string required The email address of the customer. Example: john.doe@example.com
     *
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "first_name": "John",
     *     "last_name": "Doe",
     *     "email": "john.doe@example.com",
     *     "phone": "+1 234 555 66 77"
     *   },
     *   "message": "User created successfully."
     * }
     * @responseField data.id The ID of the customer.
     * @responseField data.first_name The first name of the customer.
     * @responseField data.last_name The last name of the customer.
     * @responseField data.email The email address of the customer.
     * @responseField data.phone The phone number of the customer.
     * @responseField message A success message for the operation.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService
            ->createCustomer($request->validated());

        return ResponseBuilder::created(
            data: $customer->toArray(),
            message: 'User created successfully.',
        );
    }
}
