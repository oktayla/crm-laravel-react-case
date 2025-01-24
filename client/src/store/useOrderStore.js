import { create } from 'zustand'
import { persist } from 'zustand/middleware'
import { api } from '@/lib/api'
import useAuthStore from './useAuthStore'

const useOrderStore = create(
  persist(
    (set, get) => ({
      orders: [],
      meta: null,
      loading: false,
      error: null,

      orderDetails: {},

      getOrder: async (id) => {
        if (get().orderDetails[id]) {
          return get().orderDetails[id];
        }

        try {
          const token = useAuthStore.getState().token;
          const { data } = await api(token).get(`/orders/${id}`);

          set(state => ({
            orderDetails: {
              ...state.orderDetails,
              [id]: data.data
            }
          }));

          return data.data;
        } catch (error) {
          return null;
        }
      },

      fetchOrders: async ({ page = 1 }) => {
        set({ loading: true });

        try {
          const token = useAuthStore.getState().token;
          const { data } = await api(token).get(`/orders?page=${page}`);

          set({
            orders: data.data.orders,
            meta: data.data.meta,
            loading: false,
            error: null
          });
        } catch (error) {
          set({
            orders: [],
            loading: false,
            error
          });
        }
      },
    }),
    {
      name: 'order-storage',
    }
  )
)

export default useOrderStore
