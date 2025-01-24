import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Button } from '@/components/ui/button'
import { useEffect } from 'react'
import useOrderStore from '@/store/useOrderStore'
import { Link } from 'react-router'
import PaginationMeta from './PaginationMeta'
import { Badge } from './ui/badge'

const OrderList = () => {
  const { orders, meta, fetchOrders, loading } = useOrderStore()

  useEffect(() => {
    fetchOrders({ page: 1 })
  }, [])

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

  const handlePageChange = (page) => {
    fetchOrders({ page })
  }

  const numberFormatter = (number) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0,
    }).format(number)
  }

  return (
    <div>
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>Order ID</TableHead>
            <TableHead>Customer</TableHead>
            <TableHead>Total Amount</TableHead>
            <TableHead>Status</TableHead>
            <TableHead>Items</TableHead>
            <TableHead className="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          {loading ? (
              <TableRow>
                <TableCell colSpan={6} className="text-center">
                  Loading...
                </TableCell>
              </TableRow>
          ) : (
            <>
              {orders.map((order) => (
                <TableRow key={order.id}>
                  <TableCell className="font-medium">#{order.id}</TableCell>
                  <TableCell>
                    <div className="flex flex-col">
                      <span>{order.customer.full_name}</span>
                      <span className="text-xs text-muted-foreground">
                    {order.customer.email}
                  </span>
                    </div>
                  </TableCell>
                  <TableCell>{numberFormatter(order.total_amount)}</TableCell>
                  <TableCell>
                    <Badge variant="outline" className={getStatusClass(order.status)}>
                      {order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                    </Badge>
                  </TableCell>
                  <TableCell>{order.items_count} item(s)</TableCell>
                  <TableCell className="text-right">
                    <Link to={`/orders/${order.id}`}>
                      <Button variant="outline" size="sm">View</Button>
                    </Link>
                  </TableCell>
                </TableRow>
              ))}
            </>
          )}
        </TableBody>
      </Table>

      <PaginationMeta meta={meta} handlePageChange={handlePageChange} />

    </div>
  )
}

export default OrderList

