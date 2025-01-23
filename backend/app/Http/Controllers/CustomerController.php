<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseBuilder;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\MetaResource;
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
     * @queryParam per_page int Number of customers per page. Defaults to 10. Minimum value: 1. Maximum value: 100. Example: 15
     * @queryParam page int The page number to retrieve. Defaults to 1. Example: 2
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
     *     "meta": {
     *       "current_page": 1,
     *       "per_page": 10,
     *       "total": 1,
     *       "has_next": false
     *     }
     *   }
     * }
     * @responseField customers[] The list of customers.
     * @responseField customers[].id The ID of the customer.
     * @responseField customers[].first_name The first name of the customer.
     * @responseField customers[].last_name The last name of the customer.
     * @responseField customers[].phone The phone number of the customer.
     * @responseField customers[].email The email address of the customer.
     * @responseField meta The pagination metadata.
     * @responseField meta.current_page The current page of the pagination.
     * @responseField meta.per_page The number of items per page.
     * @responseField meta.total The total number of customers.
     * @responseField meta.has_next Whether there are more pages of customers.
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
                'meta' => MetaResource::make($customers),
            ]
        );
    }

    /**
     * Get Customer Details
     *
     * Retrieve detailed information about a specific customer, including their associated orders and order items.
     *
     * @authenticated
     *
     * @urlParam id int Required. The ID of the customer to retrieve. Example: 103
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Successful.",
     *   "data": {
     *     "id": 103,
     *     "first_name": "Kevin",
     *     "last_name": "Brekke",
     *     "full_name": "Kevin Brekke",
     *     "phone": "+1-847-407-9358",
     *     "email": "rjenkins@example.org",
     *     "orders": [
     *       {
     *         "id": 3,
     *         "status": "processing",
     *         "total_amount": "2003.04",
     *         "note": null,
     *         "items": [
     *           {
     *             "id": 9,
     *             "quantity": 3,
     *             "unit_price": "667.68",
     *             "subtotal": "2003.04",
     *             "product": {
     *               "id": 110,
     *               "name": "Nam Laboriosam Quas",
     *               "description": "Quasi id eum suscipit similique iusto sint repellat similique.",
     *               "unit_price": "667.68",
     *               "stock": 189,
     *               "is_active": true,
     *               "out_of_stock": false
     *             }
     *           },
     *           {
     *             "id": 19,
     *             "quantity": 6,
     *             "unit_price": "464.74",
     *             "subtotal": "2788.44",
     *             "product": {
     *               "id": 59,
     *               "name": "Esse Iure Veritatis",
     *               "description": "Blanditiis qui tempora impedit sed autem est velit.",
     *               "unit_price": "464.74",
     *               "stock": 178,
     *               "is_active": true,
     *               "out_of_stock": false
     *             }
     *           }
     *         ]
     *       }
     *     ]
     *   }
     * }
     * @responseField id The ID of the customer.
     * @responseField first_name The first name of the customer.
     * @responseField last_name The last name of the customer.
     * @responseField full_name The full name of the customer.
     * @responseField phone The phone number of the customer.
     * @responseField email The email address of the customer.
     * @responseField orders[] A list of orders associated with the customer.
     * @responseField orders[].id The ID of the order.
     * @responseField orders[].status The status of the order (e.g., processing, completed).
     * @responseField orders[].total_amount The total amount of the order.
     * @responseField orders[].note A note associated with the order, if any.
     * @responseField orders[].items[] The list of items in the order.
     * @responseField orders[].items[].id The ID of the order item.
     * @responseField orders[].items[].quantity The quantity of the product in the order item.
     * @responseField orders[].items[].unit_price The unit price of the product in the order item.
     * @responseField orders[].items[].subtotal The subtotal for the order item (quantity × unit price).
     * @responseField orders[].items[].product The product details associated with the order item.
     * @responseField orders[].items[].product.id The ID of the product.
     * @responseField orders[].items[].product.name The name of the product.
     * @responseField orders[].items[].product.description The description of the product.
     * @responseField orders[].items[].product.unit_price The unit price of the product.
     * @responseField orders[].items[].product.stock The stock quantity of the product.
     * @responseField orders[].items[].product.is_active Whether the product is active.
     * @responseField orders[].items[].product.out_of_stock Whether the product is out of stock.
     */

    public function show(int $id): JsonResponse
    {
        $customer = $this->customerService->getCustomerDetails($id, ['orders.items.product']);

        return ResponseBuilder::success(
            data: CustomerResource::make($customer),
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

    /**
     * Search Customers
     *
     * Search for customers based on a query string. The search matches the customer's first name, last name, email, or phone number.
     *
     * @authenticated
     *
     * @queryParam q string Required. The query string to search for. Example: John
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
     *     "meta": {
     *       "current_page": 1,
     *       "per_page": 10,
     *       "total": 1,
     *       "has_next": false
     *     }
     *   }
     * }
     * @responseField customers[] The list of customers matching the query.
     * @responseField customers[].id The ID of the customer.
     * @responseField customers[].first_name The first name of the customer.
     * @responseField customers[].last_name The last name of the customer.
     * @responseField customers[].phone The phone number of the customer.
     * @responseField customers[].email The email address of the customer.
     * @responseField meta The pagination metadata.
     * @responseField meta.current_page The current page of the pagination.
     * @responseField meta.per_page The number of items per page.
     * @responseField meta.total The total number of matching customers.
     * @responseField meta.has_next Whether there are more pages of matching customers.
     */
    public function search(Request $request): JsonResponse
    {
        $customers = $this->customerService->searchCustomers($request->get('q'));

        return ResponseBuilder::success(
            data: [
                'customers' => CustomerResource::collection($customers),
                'meta' => MetaResource::make($customers),
            ],
        );
    }
}
