import { useEffect } from "react";
import useAppStore from "../store/useAppStore";

function useAuth() {
  const user = useAppStore((state) => state.user);
  const setUser = useAppStore((state) => state.setUser);

  useEffect(() => {
    if (!user.name) {
      setUser({ name: "Admin User", role: "admin" });
    }
  }, [user.name, setUser]);

  return user;
}

export default useAuth;

