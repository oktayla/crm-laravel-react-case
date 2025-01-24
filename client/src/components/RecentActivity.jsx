import { User, ShoppingCart } from 'lucide-react'

const RecentActivity = ({ data }) => {
  if (!data) return null;

  const allActivities = [
    ...data.recent_customers,
    ...data.recent_orders,
  ];

  const activities = allActivities.sort((a, b) => b.timestamp - a.timestamp);

  return (
    <ul className="space-y-4">
      {activities.map((activity) => (
        <li key={activity.id} className="flex items-center space-x-3">
          {activity.type === 'customer' && (
            <>
              <User className="h-5 w-5 text-primary" />
              <div>
                <p className="text-sm font-medium">{activity.name}</p>
                <p className="text-xs text-neutral">
                  Joined at {activity.registration_date}
                </p>
              </div>
            </>
          )}

          {activity.type === 'order' && (
            <>
              <ShoppingCart className="h-5 w-5 text-primary" />
              <div>
                <p className="text-sm font-medium">Order #{activity.id}</p>
                <p className="text-xs text-neutral">
                  Placed by {activity.customer.name} at {activity.created_at}
                </p>
              </div>
            </>
          )}
        </li>
      ))}
    </ul>
  )
}

export default RecentActivity

