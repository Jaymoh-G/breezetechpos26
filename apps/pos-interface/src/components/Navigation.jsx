import Container from "react-bootstrap/Container";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import { LinkContainer } from "react-router-bootstrap";

function Navigation() {
  return (
    <Navbar bg="white" expand="lg" className="shadow-sm rounded">
      <Container fluid>
        <Navbar.Brand href="/">POS</Navbar.Brand>
        <Navbar.Toggle aria-controls="pos-navbar" />
        <Navbar.Collapse id="pos-navbar">
          <Nav className="me-auto">
            <LinkContainer to="/">
              <Nav.Link>Sales</Nav.Link>
            </LinkContainer>
            <LinkContainer to="/orders">
              <Nav.Link>Orders</Nav.Link>
            </LinkContainer>
            <LinkContainer to="/inventory">
              <Nav.Link>Inventory</Nav.Link>
            </LinkContainer>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}

export default Navigation;

