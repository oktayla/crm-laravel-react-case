import { Navigate, Outlet } from 'react-router'
import useAuthStore from '@/store/useAuthStore'

export const ProtectedRoute = () => {
  const { isAuthenticated } = useAuthStore();

  return isAuthenticated ? <Outlet /> : <Navigate to="/login" replace />;
};

export const RedirectIfAuthenticated = ({ children }) => {
  const { isAuthenticated } = useAuthStore();

  return isAuthenticated ? <Navigate to="/dashboard" replace /> : children;
};
