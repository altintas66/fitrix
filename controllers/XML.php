<?php

class XML { 
	
	private $helper;

	
	public function __construct($helper) 
	{		
		$this->helper         = $helper;
	

	}
 
    public function generateEInvoiceXML($rechnung, $rechnung_positionen) 
    {
        // Start der XML-Ausgabe
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"></Invoice>');
        
        // Grundlegende Rechnungsdaten
        $xml->addChild('cbc:ID', $rechnung['rechnungsnummer '], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addChild('cbc:IssueDate', $rechnung['rechnungsdatum'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addChild('cbc:InvoiceTypeCode', '380', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addChild('cbc:DocumentCurrencyCode', 'EUR', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
    
        // Lieferantendaten
        $supplierParty = $xml->addChild('cac:AccountingSupplierParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $supplierDetails = $supplierParty->addChild('cac:Party', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $supplierDetails->addChild('cbc:CompanyID', $rechnung['agentur_umsatzsteuer_id'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $supplierDetails->addChild('cbc:Name', $rechnung['agentur_firmen_name'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $supplierDetails->addChild('cbc:PostalAddress', $rechnung['agentur_strasse'].$rechnung['agentur_plz'].$rechnung['agentur_ort'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
    
        // Kundendaten
        $customerParty = $xml->addChild('cac:AccountingCustomerParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $customerDetails = $customerParty->addChild('cac:Party', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $customerDetails->addChild('cbc:CompanyID', $rechnung['kunde_umsatzsteuer_id'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $customerDetails->addChild('cbc:Name', $rechnung['kunde_firmen_name'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $customerDetails->addChild('cbc:PostalAddress', $rechnung['kunde_strasse'].$rechnung['kunde_plz'].$rechnung['kunde_ort'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
    
        // Rechnungszeilen
        $lineTotal = 0;
        foreach ($rechnung_positionen as $index => $item) {
            $line = $xml->addChild('cac:InvoiceLine', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
            $line->addChild('cbc:ID', $index + 1, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
            $line->addChild('cbc:InvoicedQuantity', $item['artikel_menge'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                 ->addAttribute('unitCode', $item['artikel_einheit']);
            $line->addChild('cbc:LineExtensionAmount', $item['artikel_preis'] * $item['artikel_menge'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                 ->addAttribute('currencyID', 'EUR');
            
            $itemNode = $line->addChild('cac:Item', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
            $itemNode->addChild('cbc:Name', $item['artikel_name'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
            $itemNode->addChild('cbc:Description', $item['artikel_beschreibung'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
            
            $priceNode = $line->addChild('cac:Price', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
            $priceNode->addChild('cbc:PriceAmount', $item['artikel_preis'], 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                      ->addAttribute('currencyID', 'EUR');
    
            $lineTotal += $item['artikel_preis'] * $item['artikel_menge'];
        }
    
        // Steuern berechnen
        $taxAmount = $lineTotal * ($rechnung['mwst_satz'] / 100);
    
        $taxTotal = $xml->addChild('cac:TaxTotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $taxTotal->addChild('cbc:TaxAmount', number_format($taxAmount, 2, '.', ''), 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                 ->addAttribute('currencyID', 'EUR');
    
        $taxSubtotal = $taxTotal->addChild('cac:TaxSubtotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $taxSubtotal->addChild('cbc:TaxableAmount', number_format($lineTotal, 2, '.', ''), 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                    ->addAttribute('currencyID', 'EUR');
        $taxSubtotal->addChild('cbc:TaxAmount', number_format($taxAmount, 2, '.', ''), 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                    ->addAttribute('currencyID', 'EUR');
    
        // Gesamtsummen
        $legalMonetaryTotal = $xml->addChild('cac:LegalMonetaryTotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $legalMonetaryTotal->addChild('cbc:LineExtensionAmount', number_format($lineTotal, 2, '.', ''), 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                           ->addAttribute('currencyID', 'EUR');
        $legalMonetaryTotal->addChild('cbc:TaxExclusiveAmount', number_format($lineTotal, 2, '.', ''), 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                           ->addAttribute('currencyID', 'EUR');
        $legalMonetaryTotal->addChild('cbc:TaxInclusiveAmount', number_format($lineTotal + $taxAmount, 2, '.', ''), 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                           ->addAttribute('currencyID', 'EUR');
        $legalMonetaryTotal->addChild('cbc:PayableAmount', number_format($lineTotal + $taxAmount, 2, '.', ''), 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2')
                           ->addAttribute('currencyID', 'EUR');
    
        // XML in einen String umwandeln und zurückgeben
        return $xml->asXML();
    }
    
	

/*
1. Rechnungskopf (Header)
cbc:ID: Die Rechnungsnummer (Pflichtfeld).
cbc:IssueDate: Das Rechnungsdatum (Pflichtfeld).
cbc:InvoiceTypeCode: Der Typ der Rechnung (z.B. "380" für eine reguläre Rechnung, "381" für eine Gutschrift).
cbc:DocumentCurrencyCode: Die Währung der Rechnung, z.B. "EUR" für Euro.
cbc:Note: Eine optionale Notiz oder Beschreibung (z.B. für Referenzen oder Bedingungen).

2. Rechnungsadressaten und Lieferant (Parties)
cac:AccountingSupplierParty: Die Partei, die die Rechnung stellt (Lieferant).
cbc:Name: Name des Lieferanten.
cac:PostalAddress: Adresse des Lieferanten.
cbc:CompanyID: Steuernummer oder USt-ID des Lieferanten.
cac:AccountingCustomerParty: Die Partei, die die Rechnung empfängt (Kunde).
cbc:Name: Name des Kunden.
cac:PostalAddress: Adresse des Kunden.

3. Rechnungspositionen
cac:InvoiceLine: Jede Position in der Rechnung.
cbc:ID: Position-ID (z.B. 1, 2, 3).
cbc:InvoicedQuantity: Menge des Artikels (Pflichtfeld).
cbc:LineExtensionAmount: Preis der Position (Pflichtfeld).
cac:Item: Informationen zu den einzelnen Artikeln.
cbc:Name: Name des Artikels.
cbc:Description: Optionale Beschreibung des Artikels.
cac:Price: Preis der Position.
cbc:PriceAmount: Preisbetrag (Pflichtfeld).

4. Steuerinformationen
cac:TaxTotal: Steuerbeträge für die gesamte Rechnung.
cbc:TaxAmount: Gesamtsteuerbetrag (Pflichtfeld).
cac:TaxSubtotal: Steueraufteilungen für einzelne Steuersätze.
cbc:TaxableAmount: Steuerpflichtiger Betrag.
cbc:TaxAmount: Steuerbetrag für diese Position.
cbc:Percent: Steuersatz (z.B. 19% für Deutschland).

5. Zahlungsinformationen
cbc:PayableAmount: Der zu zahlende Gesamtbetrag.
cbc:PaymentMeans: Informationen zu den Zahlungsmethoden.
cbc:PaymentMeansCode: Zahlungscode (z.B. Banküberweisung).
cbc:PayeeFinancialAccount: Zahlungsdetails des Empfängers (z.B. IBAN).

6. Weitere relevante Felder
cbc:DueDate: Fälligkeitsdatum der Zahlung.
cbc:PaymentTerms: Zahlungsbedingungen (z.B. "Zahlbar innerhalb von 30 Tagen").
cac:BillingReference: Referenz zur Bestellung oder Vertrag.
cac:OrderReference: Bestellreferenz (falls zutreffend)
*/

		
}