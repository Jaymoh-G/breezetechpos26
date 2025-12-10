import { createBrowserRouter } from "react-router-dom";
import App from "../App";
import HomePage from "../pages/HomePage";
import ProductsPage from "../pages/ProductsPage";
import CategoriesPage from "../pages/CategoriesPage";
import InventoryPage from "../pages/InventoryPage";
import OrdersPage from "../pages/OrdersPage";
import SalesPage from "../pages/SalesPage";
import CustomersPage from "../pages/CustomersPage";
import BranchesPage from "../pages/BranchesPage";
import UsersPage from "../pages/UsersPage";
import SettingsPage from "../pages/SettingsPage";

const router = createBrowserRouter([
  {
    path: "/",
    element: <App />,
    children: [
      { index: true, element: <HomePage /> },
      { path: "products", element: <ProductsPage /> },
      { path: "categories", element: <CategoriesPage /> },
      { path: "inventory", element: <InventoryPage /> },
      { path: "orders", element: <OrdersPage /> },
      { path: "sales", element: <SalesPage /> },
      { path: "customers", element: <CustomersPage /> },
      { path: "branches", element: <BranchesPage /> },
      { path: "users", element: <UsersPage /> },
      { path: "settings", element: <SettingsPage /> }
    ]
  }
]);

export default router;

