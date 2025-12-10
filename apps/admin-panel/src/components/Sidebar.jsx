import Nav from "react-bootstrap/Nav";
import Card from "react-bootstrap/Card";
import { LinkContainer } from "react-router-bootstrap";

function Sidebar() {
  return (
    <Card className="rounded-0 min-vh-100 shadow-sm">
      <Card.Header className="fw-semibold">Navigation</Card.Header>
      <Nav className="flex-column p-2">
        <LinkContainer to="/">
          <Nav.Link>Dashboard</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/products">
          <Nav.Link>Products</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/categories">
          <Nav.Link>Categories</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/inventory">
          <Nav.Link>Inventory</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/orders">
          <Nav.Link>Orders</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/sales">
          <Nav.Link>Sales</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/customers">
          <Nav.Link>Customers</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/branches">
          <Nav.Link>Branches</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/users">
          <Nav.Link>Users</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/settings">
          <Nav.Link>Settings</Nav.Link>
        </LinkContainer>
      </Nav>
    </Card>
  );
}

export default Sidebar;

