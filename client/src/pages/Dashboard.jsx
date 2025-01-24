import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import SalesChart from '../components/SalesChart'
import RecentActivity from '../components/RecentActivity'
import useDashboardStore from '../store/useDashboardStore'
import { useEffect } from 'react'
import { DollarSign, Users, TrendingUp, ShoppingCart } from 'lucide-react'

const Dashboard = () => {
  const { stats, recentActivity, fetchStats, fetchRecentActivity } = useDashboardStore()

  useEffect(() => {
    fetchStats()
    fetchRecentActivity()
  }, [])

  const numberFormatter = (number) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0,
    }).format(number)
  }

  const metrics = [
    { title: "Total Sales", value: stats.total_sales, icon: DollarSign, color: "text-green-500" },
    { title: "Customers", value: stats.total_customers, icon: Users, color: "text-blue-500" },
    { title: "Revenue", value: numberFormatter(stats.total_revenue), icon: TrendingUp, color: "text-yellow-500" },
    { title: "Orders", value: stats.total_orders, icon: ShoppingCart, color: "text-pink-500" },
  ]

  return (
    <div className="p-6">
      <h1 className="text-3xl font-bold mb-6">Dashboard</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        {metrics.map((metric, index) => (
          <Card key={index}>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium">{metric.title}</CardTitle>
              <metric.icon size={24} className={metric.color} />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{metric.value}</div>
            </CardContent>
          </Card>
        ))}
      </div>
      <div className="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
        <Card className={`lg:col-span-3`}>
          <CardHeader>
            <CardTitle>Sales Performance</CardTitle>
          </CardHeader>
          <CardContent>
            <SalesChart data={stats.sales_performance} />
          </CardContent>
        </Card>
        <Card className={`lg:col-span-2`}>
          <CardHeader>
            <CardTitle>Recent Activity</CardTitle>
          </CardHeader>
          <CardContent>
            <RecentActivity data={recentActivity} />
          </CardContent>
        </Card>
      </div>
    </div>
  )
}

export default Dashboard

