import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import {useEffect, useState} from 'react'
import useCustomerStore from '@/store/useCustomerStore'
import { Link } from 'react-router'
import PaginationMeta from './PaginationMeta'

const CustomerList = () => {
  const { customers, meta, fetchCustomers, searchCustomers, loading } = useCustomerStore()

  const [searchTerm, setSearchTerm] = useState('')

  useEffect(() => {
    fetchCustomers({ page: 1 })
  }, [])


  const handleSearch = () => {
    if (searchTerm) {
      searchCustomers({ query: searchTerm })
    } else {
      fetchCustomers({ page: 1 })
    }
  }

  const handlePageChange = (page) => {
    if (searchTerm) {
      searchCustomers({ query: searchTerm, page })
    } else {
      fetchCustomers({ page })
    }
  }

  useEffect(() => {
    handleSearch()
  }, [searchTerm])

  return (
    <div>
      <div className="mb-4">
        <Input
          type="text"
          placeholder="Search customers..."
          onChange={(e) => setSearchTerm(e.target.value)}
          className="max-w-sm"
        />
      </div>
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>Name</TableHead>
            <TableHead>Email</TableHead>
            <TableHead>Phone</TableHead>
            <TableHead></TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          {loading ? (
            <TableRow>
              <TableCell colSpan={3} className="text-center">
                Loading...
              </TableCell>
            </TableRow>
          ) : (
            <>
              {customers.map((customer) => (
                <TableRow key={customer.id}>
                  <TableCell className="font-medium">{customer.full_name}</TableCell>
                  <TableCell>{customer.email}</TableCell>
                  <TableCell>{customer.phone}</TableCell>
                  <TableCell className="text-end">
                    <Link to={`/customers/${customer.id}`}>
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

export default CustomerList

