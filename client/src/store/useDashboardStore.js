import { create } from 'zustand';
import { persist } from 'zustand/middleware'
import useAuthStore from './useAuthStore.js'
import {api} from '../lib/api'

export const useDashboardStore = create(
  persist(
    (set) => ({
      stats: {
        total_orders: 0,
        total_revenue: 0,
        total_sales: 0,
        total_customers: 0,
        sales_performance: null,
      },
      recentActivity: null,

      fetchStats: async () => {
        const token = useAuthStore.getState().token;

        const { data } = await api(token).get('/dashboard/stats');
        set({ stats: data.data });
      },

      fetchRecentActivity: async () => {
        const token = useAuthStore.getState().token;

        const {data} = await api(token).get('/dashboard/recent-activity');
        set({recentActivity: data});
      }
    }),
    {
      name: 'dashboard-store',
    }
  )
)

export default useDashboardStore;
