import Sidebar from './components/Sidebar.jsx'
import Dashboard from './pages/Dashboard.jsx'

const App = () => {
  return (
    <div className="flex h-screen bg-background text-neutral-700">
      <Sidebar />
      <main className="flex-1 overflow-x-hidden overflow-y-auto bg-background">
        <Dashboard />
      </main>
    </div>
  )
}

export default App

