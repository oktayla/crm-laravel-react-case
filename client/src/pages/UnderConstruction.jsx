import { Link } from 'react-router'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Construction } from 'lucide-react'

const UnderConstruction = () => {
  return (
    <div className="p-6 flex justify-center items-center min-h-screen bg-gray-100">
      <Card className="max-w-md w-full text-center">
        <CardHeader>
          <CardTitle className="flex justify-center items-center">
            <Construction className="mr-2 h-8 w-8 text-gray-500" />
            Under Construction
          </CardTitle>
        </CardHeader>
        <CardContent>
          <p className="text-gray-600 mb-4">
            This page is currently under construction. Please check back later.
          </p>
          <Link to="/">
            <Button variant="outline">Go to Home</Button>
          </Link>
        </CardContent>
      </Card>
    </div>
  )
}

export default UnderConstruction
