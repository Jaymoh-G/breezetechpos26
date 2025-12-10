import { create } from "zustand";

const useAppStore = create((set) => ({
  user: { name: "", role: "" },
  cart: [],
  setUser: (user) => set({ user }),
  addItem: (item) => set((state) => ({ cart: [...state.cart, item] }))
}));

export default useAppStore;

