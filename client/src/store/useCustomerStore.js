import { create } from 'zustand'
import { persist } from 'zustand/middleware'
import { api } from '@/lib/api'
import useAuthStore from './useAuthStore'

const useCustomerStore = create(
  persist(
    (set, get) => ({
      customers: [],
      meta: null,
      loading: false,
      error: null,

      customerDetails: {},

      getCustomer: async (id) => {
        if (get().customerDetails[id]) {
          return get().customerDetails[id];
        }

        try {
          const token = useAuthStore.getState().token;
          const { data } = await api(token).get(`/customers/${id}`);

          set(state => ({
            customerDetails: {
              ...state.customerDetails,
              [id]: data.data
            }
          }));

          return data.data;
        } catch (error) {
          return null;
        }
      },

      fetchCustomers: async ({ page = 1 }) => {
        set({ loading: true });

        try {
          const token = useAuthStore.getState().token;
          const { data } = await api(token).get(`/customers?page=${page}`);

          set({
            customers: data.data.customers,
            meta: data.data.meta,
            loading: false,
            error: null
          });
        } catch (error) {
          set({
            customers: [],
            loading: false,
            error
          });
        }
      },

      searchCustomers: async ({ query, page = 1 }) => {
        set({ loading: true });

        try {
          const token = useAuthStore.getState().token;
          const { data } = await api(token).get(`/customers/search?q=${query}&page=${page}`);

          set({
            customers: data.data.customers,
            meta: data.data.meta,
            loading: false,
            error: null
          });
        } catch (error) {
          set({
            customers: [],
            loading: false,
            error
          });
        }
      },
    }),
    {
      name: 'customer-storage',
    }
  )
)

export default useCustomerStore
