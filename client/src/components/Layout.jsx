import Sidebar from '@/components/Sidebar'
import { Outlet } from 'react-router'

const Layout = () => {
  return (
    <div className="flex h-screen bg-background text-neutral-700">
      <Sidebar />
      <main className="flex-1 overflow-x-hidden overflow-y-auto bg-background">
        <Outlet />
      </main>
    </div>
  )
}

export default Layout

