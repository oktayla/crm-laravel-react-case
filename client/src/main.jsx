import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter, Routes, Route } from 'react-router'
import Layout from '@/components/Layout'
import Dashboard from './pages/Dashboard'
import Login from './pages/Login'
import Customers from './pages/Customers'
import CustomerDetail from './pages/CustomersDetail'
import { ProtectedRoute, RedirectIfAuthenticated } from '@/lib/checkAuth'
import Orders from './pages/Orders'
import OrderDetail from './pages/OrderDetail'
import UnderConstruction from './pages/UnderConstruction'
import './index.css'

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <BrowserRouter>
      <Routes>
        <Route element={<ProtectedRoute />}>
          <Route path="/" element={<Layout />}>
            <Route index element={<Dashboard />} />
            <Route path="/dashboard" element={<Dashboard />} />
            <Route path="/customers" element={<Customers />} />
            <Route path="/customers/:id" element={<CustomerDetail />} />

            <Route path={"/orders"} element={<Orders />} />
            <Route path={"/orders/:id"} element={<OrderDetail />} />

            <Route path="/reports" element={<UnderConstruction />} />
            <Route path="/profile" element={<UnderConstruction />} />
          </Route>
        </Route>

        <Route path="/login" element={
          <RedirectIfAuthenticated>
            <Login />
          </RedirectIfAuthenticated>
        }>
        </Route>
      </Routes>
    </BrowserRouter>
  </StrictMode>,
)
