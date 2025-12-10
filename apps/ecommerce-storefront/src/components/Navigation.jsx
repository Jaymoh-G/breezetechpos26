import Container from "react-bootstrap/Container";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import { LinkContainer } from "react-router-bootstrap";

function Navigation() {
  return (
    <Navbar bg="white" expand="lg" className="shadow-sm rounded">
      <Container fluid>
        <Navbar.Brand href="/">Storefront</Navbar.Brand>
        <Navbar.Toggle aria-controls="store-navbar" />
        <Navbar.Collapse id="store-navbar">
          <Nav className="me-auto">
            <LinkContainer to="/">
              <Nav.Link>Home</Nav.Link>
            </LinkContainer>
            <LinkContainer to="/catalog">
              <Nav.Link>Catalog</Nav.Link>
            </LinkContainer>
            <LinkContainer to="/cart">
              <Nav.Link>Cart</Nav.Link>
            </LinkContainer>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}

export default Navigation;

