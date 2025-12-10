import Nav from "react-bootstrap/Nav";
import Card from "react-bootstrap/Card";
import { LinkContainer } from "react-router-bootstrap";

function Sidebar() {
  return (
    <Card className="rounded-0 min-vh-100 shadow-sm">
      <Card.Header className="fw-semibold">POS Menu</Card.Header>
      <Nav className="flex-column p-2">
        <LinkContainer to="/">
          <Nav.Link>Quick Sale</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/orders">
          <Nav.Link>Orders</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/inventory">
          <Nav.Link>Inventory</Nav.Link>
        </LinkContainer>
      </Nav>
    </Card>
  );
}

export default Sidebar;

