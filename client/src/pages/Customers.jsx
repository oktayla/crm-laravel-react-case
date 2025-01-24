import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import CustomerList from "../components/CustomerList"
import { Button } from "@/components/ui/button"
import { PlusCircle } from "lucide-react"

const Customers = () => {
  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-3xl font-bold">Customers</h1>
        <Button className="bg-blue-700 hover:bg-blue-700/90 text-white">
          <PlusCircle className="mr-2 h-4 w-4" /> Add New Customer
        </Button>
      </div>
      <Card>
        <CardHeader>
          <CardTitle>Customer List</CardTitle>
        </CardHeader>
        <CardContent>
          <CustomerList />
        </CardContent>
      </Card>
    </div>
  )
}

export default Customers

