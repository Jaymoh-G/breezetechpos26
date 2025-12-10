import { useQuery } from "@tanstack/react-query";
import api from "../lib/api";

export function useFetch(key, url, options = {}) {
  return useQuery({
    queryKey: Array.isArray(key) ? key : [key],
    queryFn: async () => {
      const { data } = await api.get(url);
      return data?.data ?? data;
    },
    ...options,
  });
}

