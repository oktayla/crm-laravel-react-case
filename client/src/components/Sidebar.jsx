import { Home, Users, ShoppingCart, BarChart2, User } from "lucide-react"
import { Link } from 'react-router'

const Sidebar = () => {
  const menuItems = [
    { icon: Home, text: "Dashboard", link: "/" },
    { icon: Users, text: "Customers", link: "/customers" },
    { icon: ShoppingCart, text: "Sales/Orders", link: "/orders" },
    { icon: BarChart2, text: "Reports", link: "/reports" },
    { icon: User, text: "Profile", link: "/profile" },
  ]

  return (
    <div className="flex flex-col w-64 border-r">
      <div className="flex items-center justify-center h-20">
        <h1 className="text-3xl font-extrabold">
          <span>crm</span>
          <span className="text-secondary">.</span>
          <span>hive</span>
        </h1>
      </div>
      <ul className="flex flex-col py-4 mx-5">
        {menuItems.map((item, index) => (
          <li key={index}>
            <Link
              to={item.link}
              className="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 hover:text-primary"
            >
              <span className="inline-flex items-center justify-center h-12 w-8">
                <item.icon size={16} />
              </span>
              <span className="text-sm font-medium">{item.text}</span>
            </Link>
          </li>
        ))}
      </ul>
    </div>
  )
}

export default Sidebar



