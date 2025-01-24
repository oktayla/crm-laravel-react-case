import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer
} from 'recharts'

const SalesChart = ({ data }) => {
  if (!data) return null;

  const chartData = data.labels.map((label, index) => ({
    name: label,
    sales: parseFloat(data.datasets[0].data[index])
  })).sort((a, b) => new Date(a.name) - new Date(b.name));

  return (
    <div className="p-4 bg-white rounded-lg shadow-md">
      <div className="mb-4">
        <h2 className="text-xl font-semibold text-gray-800">Sales Performance</h2>
        <div className="flex justify-between text-sm text-gray-600">
          <p>Total Sales: ${data.metadata.total_sales.toLocaleString()}</p>
          <p>Avg. Monthly Sales: ${data.metadata.average_monthly_sales.toLocaleString()}</p>
        </div>
      </div>
      <ResponsiveContainer width="100%" height={300}>
        <LineChart data={chartData}>
          <CartesianGrid strokeDasharray="3 3" stroke="#e0e0e0" />
          <XAxis
            dataKey="name"
            tickFormatter={(tick) => {
              // Format date to be more readable
              const date = new Date(tick);
              return date.toLocaleString('default', { month: 'short', year: '2-digit' });
            }}
          />
          <YAxis
            tickFormatter={(tick) => `$${tick.toLocaleString()}`}
          />
          <Tooltip
            formatter={(value) => [`$${parseFloat(value).toLocaleString()}`, 'Sales']}
            labelFormatter={(label) => {
              const date = new Date(label);
              return date.toLocaleString('default', { month: 'long', year: 'numeric' });
            }}
          />
          <Legend />
          <Line
            type="monotone"
            dataKey="sales"
            stroke="#1E40AF"
            strokeWidth={2}
            dot={{ r: 4, fill: '#1E40AF', stroke: 'white', strokeWidth: 2 }}
            activeDot={{ r: 8, fill: '#1E40AF', stroke: 'white', strokeWidth: 2 }}
          />
        </LineChart>
      </ResponsiveContainer>
    </div>
  )
}

export default SalesChart
