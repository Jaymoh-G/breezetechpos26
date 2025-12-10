import Nav from "react-bootstrap/Nav";
import Card from "react-bootstrap/Card";
import { LinkContainer } from "react-router-bootstrap";

function Sidebar() {
  return (
    <Card className="rounded-0 min-vh-100 shadow-sm">
      <Card.Header className="fw-semibold">Browse</Card.Header>
      <Nav className="flex-column p-2">
        <LinkContainer to="/">
          <Nav.Link>Featured</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/catalog">
          <Nav.Link>Catalog</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/cart">
          <Nav.Link>Cart</Nav.Link>
        </LinkContainer>
      </Nav>
    </Card>
  );
}

export default Sidebar;

