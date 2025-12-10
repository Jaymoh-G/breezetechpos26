import { Outlet } from "react-router-dom";
import Navigation from "../components/Navigation";
import Sidebar from "../components/Sidebar";

const MainLayout = {
  Navbar: Navigation,
  Sidebar,
  Outlet
};

export default MainLayout;

