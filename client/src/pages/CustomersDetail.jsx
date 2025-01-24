import { useEffect, useState } from 'react'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import {
  Mail,
  Phone,
  User,
  ArrowLeft,
  ShoppingCart,
  Package
} from 'lucide-react'
import { Link, useParams } from 'react-router'
import useCustomerStore from '../store/useCustomerStore'

const OrderSummary = ({ orders }) => {
  if (!orders || orders.length === 0) {
    return (
      <div className="bg-gray-50 p-4 rounded-lg text-center">
        <p className="text-gray-600">No orders found</p>
      </div>
    )
  }

  const numberFormatter = (number) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0,
    }).format(number)
  }

  return (
    <div className="bg-gray-50 p-4 rounded-lg">
      <h3 className="text-lg font-semibold mb-3 flex items-center">
        <ShoppingCart className="mr-2 h-5 w-5 text-gray-500" />
        Order History
      </h3>
      {orders.map((order) => (
        <div
          key={order.id}
          className="border-b last:border-b-0 p-3 rounded-xl hover:bg-gray-100 transition-colors"
        >
          <div className="flex justify-between items-center">
            <div>
              <p className="font-medium">Order #{order.id}</p>
              <p className="text-sm text-gray-600">
                Total: {numberFormatter(order.total_amount)}
              </p>
            </div>
            <Badge
              variant={
                order.status === 'processing' ? 'warning' :
                  order.status === 'completed' ? 'success' :
                    'secondary'
              }
            >
              {order.status}
            </Badge>
          </div>
          {order.items && (
            <div className="mt-2">
              <p className="text-xs text-gray-500">
                {order.items.length} Product{order.items.length !== 1 ? 's' : ''}
              </p>
              <div className="flex space-x-2 mt-1">
                {order.items.map((item) => (
                  <div
                    key={item.id}
                    className="tooltip"
                    title={item.product.name}
                  >
                    <Package className="h-4 w-4 text-gray-400" />
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>
      ))}
    </div>
  )
}

const CustomerDetail = () => {
  const { getCustomer } = useCustomerStore()
  const [customer, setCustomer] = useState(null)
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState(null)

  const { id } = useParams()

  useEffect(() => {
    const fetchCustomer = async () => {
      try {
        setIsLoading(true)
        setError(null)
        const fetchedCustomer = await getCustomer(id)
        setCustomer(fetchedCustomer)
      } catch (error) {
        console.error('Failed to fetch customer:', error)
        setError('Unable to load customer details. Please try again.')
      } finally {
        setIsLoading(false)
      }
    }

    fetchCustomer()
  }, [id])

  if (isLoading) {
    return (
      <div className="p-6 flex justify-center items-center">
        <div className="animate-pulse">
          <p>Loading customer details...</p>
        </div>
      </div>
    )
  }

  if (error) {
    return (
      <div className="p-6 flex justify-center items-center text-red-500">
        <p>{error}</p>
      </div>
    )
  }

  if (!customer) {
    return (
      <div className="p-6 flex justify-center items-center">
        <p>No customer found</p>
      </div>
    )
  }

  return (
    <div className="p-6 mx-auto">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-3xl font-bold flex items-center">
          <User className="mr-3 h-8 w-8 text-gray-500" />
          Customer Details
        </h1>
        <Link to="/customers">
          <Button variant="outline">
            <ArrowLeft className="mr-2 h-4 w-4" /> Back to Customers
          </Button>
        </Link>
      </div>

      <div className="grid md:grid-cols-3 gap-6">
        <div className="md:col-span-2">
          <Card className="h-full">
            <CardHeader>
              <CardTitle>Customer Information</CardTitle>
            </CardHeader>
            <CardContent>
              <div className="grid md:grid-cols-2 gap-4">
                <div className="space-y-4">
                  <div className="flex items-center space-x-4">
                    <User className="h-6 w-6 text-gray-500" />
                    <div>
                      <p className="font-semibold">Full Name</p>
                      <p>{customer.full_name}</p>
                    </div>
                  </div>

                  <div className="flex items-center space-x-4">
                    <Mail className="h-6 w-6 text-gray-500" />
                    <div>
                      <p className="font-semibold">Email</p>
                      <p>{customer.email}</p>
                    </div>
                  </div>

                  <div className="flex items-center space-x-4">
                    <Phone className="h-6 w-6 text-gray-500" />
                    <div>
                      <p className="font-semibold">Phone</p>
                      <p>{customer.phone}</p>
                    </div>
                  </div>
                </div>

                <div className="bg-gray-50 p-4 rounded-lg">
                  <h3 className="text-lg font-semibold mb-2">Customer Insights</h3>
                  <p className="text-gray-600">
                    Additional contextual information can be added here,
                    such as customer lifetime value, engagement metrics,
                    or other relevant business insights.
                  </p>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <div>
          <OrderSummary orders={customer.orders} />
        </div>
      </div>
    </div>
  )
}

export default CustomerDetail
