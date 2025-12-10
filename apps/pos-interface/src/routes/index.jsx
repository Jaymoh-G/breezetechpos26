import { createBrowserRouter } from "react-router-dom";
import App from "../App";
import SalesPage from "../pages/SalesPage";
import OrdersPage from "../pages/OrdersPage";
import InventoryPage from "../pages/InventoryPage";

const router = createBrowserRouter([
  {
    path: "/",
    element: <App />,
    children: [
      { index: true, element: <SalesPage /> },
      { path: "orders", element: <OrdersPage /> },
      { path: "inventory", element: <InventoryPage /> }
    ]
  }
]);

export default router;

