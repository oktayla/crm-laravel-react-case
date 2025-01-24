import {useEffect, useState} from 'react'
import {Link, useParams} from 'react-router'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import useOrderStore from '@/store/useOrderStore'

const OrderDetail = () => {
  const { id } = useParams()
  const { getOrder } = useOrderStore()
  const [order, setOrder] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const fetchOrder = async () => {
      try {
        setLoading(true)
        const fetchedCustomer = await getOrder(id)
        setOrder(fetchedCustomer)
      } finally {
        setLoading(false)
      }
    }

    fetchOrder()
  }, [id])

  const numberFormatter = (number) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0,
    }).format(number)
  }

  const getStatusClass = (status) => {
    switch (status) {
      case 'completed':
        return 'bg-green-200'
      case 'processing':
        return 'bg-blue-200'
      case 'canceled':
        return 'bg-rose-200'
      default:
        return 'bg-yellow-200'
    }
  }

  if (loading) {
    return <div className="p-6 text-center">
      <p>Loading...</p>
    </div>
  }

  return (
    <div className="p-6">
      <h1 className="text-3xl font-bold mb-6">Order Detail</h1>
      <Card className="mb-5">
        <CardHeader>
          <CardTitle>Order #{order.id}</CardTitle>
        </CardHeader>
        <CardContent>
          <div className="grid grid-cols-2 gap-4">
            <div>
              <h2 className="text-xl font-bold mb-3">Customer Information</h2>
              <p className="text-lg">{order.customer.full_name}</p>
              <p className="text-sm text-gray-500">{order.customer.email}</p>
            </div>
            <div>
              <h2 className="text-xl font-bold mb-3">Order Information</h2>
              <p className="text-sm">Status: <Badge variant="outline" className={getStatusClass(order.status)}>{order.status.charAt(0).toUpperCase() + order.status.slice(1)}</Badge></p>
              <p className="text-sm">Total Amount: {numberFormatter(order.total_amount)}</p>
            </div>
          </div>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Items</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Product Name</TableHead>
                <TableHead>Quantity</TableHead>
                <TableHead>Price</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {order.items.map((item) => (
                <TableRow key={item.id}>
                  <TableCell>{item.product.name}</TableCell>
                  <TableCell>{item.quantity}</TableCell>
                  <TableCell>{numberFormatter(item.unit_price)}</TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>

      <div className="mt-6">
        <Link to={`/orders`}>
          <Button variant="outline">Back to Orders</Button>
        </Link>
      </div>
    </div>
  )
}

export default OrderDetail
