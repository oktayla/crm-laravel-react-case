import { create } from 'zustand'
import { persist } from 'zustand/middleware'
import { api } from '@/lib/api'

const useAuthStore = create(
  persist(
    (set) => ({
      user: null,
      token: null,
      isAuthenticated: false,

      login: async (email, password) => {
        try {
          const { data } = await api().post('/login', { email, password });

          set({
            user: data.data.user,
            token: data.data.token,
            isAuthenticated: true
          });
        } catch (error) {
          set({
            user: null,
            token: null,
            isAuthenticated: false
          });
          throw error;
        }
      },

      logout: () => {
        set({
          user: null,
          token: null,
          isAuthenticated: false
        });
      }
    }),
    {
      name: 'auth-storage',
    }
  )
);

export default useAuthStore;
