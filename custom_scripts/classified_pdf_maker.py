from fpdf import FPDF


for x in range(20,21):
    # Create instance of FPDF class
    pdf = FPDF(format='letter')

    # Add a page
    pdf.add_page()

    # Set font
    pdf.set_font("Arial", size=12)

    document_text = "CLASSIFIED DOCUMENT NUMBER " + str(x)
    # Add a cell
    pdf.cell(200, 10, txt=document_text, ln=True, align='C')

    # Save the PDF with name .pdf
    filename = "CLASSIFIED DOCUMENT " + str(x) + ".pdf"
    pdf.output(filename)