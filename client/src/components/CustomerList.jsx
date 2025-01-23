import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import {useEffect, useState} from 'react'
import useCustomerStore from '@/store/useCustomerStore'
import {Link} from 'react-router'

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

      {meta && (
        <div className="flex justify-between items-center mt-4">
          <div className="text-sm">
            Showing {(meta.current_page - 1) * meta.per_page + 1} to {Math.min(meta.current_page * meta.per_page, meta.total)} of {meta.total} customers
          </div>
          <div className="space-x-2">
            <Button
              onClick={() => handlePageChange(meta.current_page - 1)}
              disabled={meta.current_page === 1}
            >
              Previous
            </Button>
            <Button
              onClick={() => handlePageChange(meta.current_page + 1)}
              disabled={!meta.has_next}
            >
              Next
            </Button>
          </div>
        </div>
      )}

    </div>
  )
}

export default CustomerList

