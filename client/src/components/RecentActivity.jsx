import { Activity } from 'lucide-react'

const activities = [
  { id: 1, action: "New customer signed up", timestamp: "2 hours ago" },
  { id: 2, action: "Order #1234 placed", timestamp: "4 hours ago" },
  { id: 3, action: "Customer feedback received", timestamp: "1 day ago" },
]

const RecentActivity = () => {
  return (
    <ul className="space-y-4">
      {activities.map((activity) => (
        <li key={activity.id} className="flex items-center space-x-3">
          <Activity className="h-5 w-5 text-primary" />
          <div>
            <p className="text-sm font-medium">{activity.action}</p>
            <p className="text-xs text-neutral-500">{activity.timestamp}</p>
          </div>
        </li>
      ))}
    </ul>
  )
}

export default RecentActivity

