import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import OrderList from "../components/OrderList"

const Customers = () => {
  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-3xl font-bold">Orders</h1>
      </div>
      <Card>
        <CardHeader>
          <CardTitle>Order List</CardTitle>
        </CardHeader>
        <CardContent>
          <OrderList />
        </CardContent>
      </Card>
    </div>
  )
}

export default Customers

