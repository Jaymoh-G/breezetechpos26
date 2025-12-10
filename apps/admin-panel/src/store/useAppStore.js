import { create } from "zustand";

const useAppStore = create((set) => ({
  user: { name: "", role: "" },
  setUser: (user) => set({ user }),
  sidebarOpen: true,
  toggleSidebar: () => set((state) => ({ sidebarOpen: !state.sidebarOpen }))
}));

export default useAppStore;

