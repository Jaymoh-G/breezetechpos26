import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import MainLayout from "./layouts/MainLayout";

function App() {
  return (
    <Container fluid className="bg-light min-vh-100">
      <Row>
        <Col md={3} lg={2} className="p-0">
          <MainLayout.Sidebar />
        </Col>
        <Col md={9} lg={10} className="p-3">
          <MainLayout.Navbar />
          <main className="mt-3">
            <MainLayout.Outlet />
          </main>
        </Col>
      </Row>
    </Container>
  );
}

export default App;

